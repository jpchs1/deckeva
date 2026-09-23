#!/usr/bin/env python3
"""Cuenta los leads reales que entraron en una ventana de tiempo (UTC).

Sirve después de una caída del correo: ¿quedó algún cliente sin respuesta?
El 23/09/2026 el hosting dejó de despachar correo durante casi dos horas y la
única forma de saber si alguien cotizó en ese rato era mirar el registro de
leads del servidor.

El repo y los logs de Actions son públicos, así que solo imprime cuántos hubo
por origen y por vía, nunca nombres, correos ni teléfonos.

Uso: contar-leads.py DESDE HASTA leads-AAAA-MM.log [más .log]
     DESDE y HASTA en UTC, con formato AAAA-MM-DDTHH:MM:SSZ.
"""
import json
import re
import sys
from collections import Counter
from datetime import datetime, timedelta

FORMATO = '%Y-%m-%dT%H:%M:%SZ'

# Envíos nuestros que también quedan en el registro: no son clientes entrando.
ORIGENES_PROPIOS = re.compile(r'^(rescate-|reactivacion-)')
# Las cotizaciones de prueba llevan "PRUEBA … Claude" en el nombre.
PRUEBA = re.compile(r'PRUEBA.*Claude', re.IGNORECASE)
# El número de cotización de la home lleva la hora UTC exacta.
NUMERO_UTC = re.compile(r'DCK-INT-(\d{14})')


def hora_del_numero(datos):
    for valor in datos.values():
        m = NUMERO_UTC.search(str(valor))
        if m:
            try:
                return datetime.strptime(m.group(1), '%Y%m%d%H%M%S')
            except ValueError:
                return None
    return None


def hora_local(entrada):
    try:
        return datetime.strptime(str(entrada.get('fecha', '')), '%Y-%m-%d %H:%M:%S')
    except ValueError:
        return None


def main(argv):
    if len(argv) < 4:
        print('Uso: contar-leads.py DESDE HASTA leads-AAAA-MM.log [más .log]')
        return 2
    try:
        desde = datetime.strptime(argv[1], FORMATO)
        hasta = datetime.strptime(argv[2], FORMATO)
    except ValueError:
        print('Ventana inválida: se espera AAAA-MM-DDTHH:MM:SSZ.')
        return 2

    entradas = []
    for ruta in argv[3:]:
        with open(ruta, encoding='utf-8', errors='replace') as f:
            for linea in f:
                try:
                    entrada = json.loads(linea)
                except ValueError:
                    continue
                if isinstance(entrada, dict):
                    entradas.append(entrada)

    # La "fecha" del registro va en la hora de WordPress, que no es UTC (va en
    # UTC+2). El desfase se saca de las entradas que traen número con hora UTC.
    desfases = Counter()
    for entrada in entradas:
        datos = entrada.get('datos') or {}
        utc, local = hora_del_numero(datos), hora_local(entrada)
        if utc and local:
            desfases[round((local - utc).total_seconds() / 3600)] += 1
    desfase = desfases.most_common(1)[0][0] if desfases else 2
    origen_desfase = 'medido' if desfases else 'supuesto'

    por_origen = Counter()
    por_via = Counter()
    pruebas = 0
    for entrada in entradas:
        origen = str(entrada.get('origen', '?'))
        if ORIGENES_PROPIOS.match(origen):
            continue
        datos = entrada.get('datos') or {}
        hora = hora_del_numero(datos)
        if hora is None:
            local = hora_local(entrada)
            if local is None:
                continue
            hora = local - timedelta(hours=desfase)
        if not (desde <= hora < hasta):
            continue
        if any(PRUEBA.search(str(v)) for v in datos.values()):
            pruebas += 1
            continue
        por_origen[origen] += 1
        if origen == 'cotizador':
            if 'Vía' in datos:
                clave = 'home, vía %s, copia al cliente: %s' % (
                    datos.get('Vía'), datos.get('Copia al cliente', '?'))
            else:
                clave = '/cotizador/ (siempre por correo)'
            por_via[clave] += 1

    print('Hora de WordPress = UTC%+d (%s)' % (desfase, origen_desfase))
    print('Contactos en la ventana: %d' % sum(por_origen.values()))
    for origen, n in sorted(por_origen.items()):
        print('  %s: %d' % (origen, n))
    for via, n in sorted(por_via.items()):
        print('    cotizador, %s: %d' % (via, n))
    print('Pruebas propias descartadas: %d' % pruebas)
    return 0


if __name__ == '__main__':
    sys.exit(main(sys.argv))
