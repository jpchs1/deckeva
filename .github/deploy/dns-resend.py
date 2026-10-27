#!/usr/bin/env python3
"""Publica en el DNS de deckeva.cl los registros que pide Resend para mandar
correo desde contacto@deckeva.cl.

Por qué existe: deckeva.cl está creado en Resend desde el 2-oct-2026 pero nunca
se verificó, porque sus tres registros (DKIM `resend._domainkey` y los CNAME
`send` y `rsend`) no se publicaron en el DNS, que administra el cPanel de
BanaHosting. Sin eso, Resend no deja mandar desde contacto@deckeva.cl y una
cotización a un cliente (27-oct-2026) se quedó sin salir.

Usa la API de cPanel (UAPI, puerto 2083) con la cuenta del hosting, la misma
del FTP de los workflows. Sólo toca esos tres nombres: no edita ni borra
ningún otro registro, y si ya existen con el valor correcto no hace nada. No
cambia el SPF ni el MX de deckeva.cl: son subdominios propios de Resend.

    MODO=ver       lista cómo están los tres registros (no escribe nada)
    MODO=agregar   agrega los que falten

El repo y sus logs son públicos: sólo se imprimen nombres, tipos y estados.
"""
import base64
import json
import os
import re
import ssl
import sys
import urllib.error
import urllib.parse
import urllib.request

ZONA = "deckeva.cl"
# Lo que pide Resend para deckeva.cl (Resend → Domains → deckeva.cl).
QUERIDOS = [
    {"dname": "resend._domainkey", "record_type": "TXT",
     "data": ["p=MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDIIbXcky8boAyz3SRK4iYE/jqbgTOucEU7nfr7tX/VNoppTM6Gjbz"
              "CXRijesAEIovTQNpy1DlRJIB+1XYS5xtIgqyNzl/Vecy+C4s73pTGmhIb03GL/mKFhv3bIH8TuRFd5eR+MzoXHCiDuChx3"
              "+ykHqfa+WqW/J6r4GmUCI1mIQIDAQAB"]},
    {"dname": "send", "record_type": "CNAME", "data": ["send.forge.rmta.net."]},
    {"dname": "rsend", "record_type": "CNAME", "data": ["rsend-sae1.forge.rmta.net."]},
]


SESIONES = {}


def sesion(host, verificar):
    """Entra a cPanel como el navegador (usuario y clave en /login) y devuelve
    (prefijo cpsess, cookie). Hace falta porque BanaHosting rechaza la clave
    por HTTP Basic en la API (401 con la página de login, 27-oct-2026) aunque
    la misma clave entre bien por la pantalla de login."""
    clave = (host, verificar)
    if clave not in SESIONES:
        datos = urllib.parse.urlencode({"user": usuario_cpanel(), "pass": clave_cpanel()}).encode()
        req = urllib.request.Request(f"https://{host}:2083/login/?login_only=1", data=datos, method="POST")
        with urllib.request.urlopen(req, context=contexto(verificar), timeout=30) as r:
            res = json.load(r)
            cookies = "; ".join(c.split(";", 1)[0] for c in r.headers.get_all("Set-Cookie") or [])
        if not res.get("status") or not res.get("security_token"):
            texto = str(res.get("message") or "sin detalle")
            for secreto in (usuario_cpanel(), clave_cpanel()):
                texto = texto.replace(secreto, "<oculto>") if secreto else texto
            raise RuntimeError(f"cPanel no aceptó el usuario y la clave: {texto[:160]}")
        SESIONES[clave] = (res["security_token"], cookies)
    return SESIONES[clave]


def usuario_cpanel():
    # strip(): al pegar un secreto en GitHub se cuela fácil un espacio o un salto
    # de línea, y cPanel lo rechaza con un «Access denied» sin más pistas.
    return os.environ["CPANEL_USER"].strip()


def clave_cpanel():
    # Un token de API de cPanel tiene 32 caracteres; si CPANEL_TOKEN trae otra
    # cosa (el 27-oct-2026 traía 12: era la clave de cPanel), es la clave.
    token = os.environ.get("CPANEL_TOKEN", "").strip()
    return token if len(token) != 32 and token else os.environ.get("CPANEL_PASS", "")


def contexto(verificar):
    return ssl.create_default_context() if verificar else ssl._create_unverified_context()


def llamar(host, funcion, params, metodo="GET", verificar=True):
    datos = urllib.parse.urlencode(params, doseq=True)
    token = os.environ.get("CPANEL_TOKEN", "").strip()
    if len(token) == 32:
        # Token de API de cPanel (Seguridad → Manage API Tokens): se revoca sin
        # cambiar la clave.
        url = f"https://{host}:2083/execute/DNS/{funcion}"
        cabeceras = {"Authorization": f"cpanel {usuario_cpanel()}:{token}"}
    else:
        cpsess, cookies = sesion(host, verificar)
        url = f"https://{host}:2083{cpsess}/execute/DNS/{funcion}"
        cabeceras = {"Cookie": cookies}
    if metodo == "GET":
        req = urllib.request.Request(url + "?" + datos, headers=cabeceras)
    else:
        req = urllib.request.Request(url, data=datos.encode(), method="POST", headers=cabeceras)
    with urllib.request.urlopen(req, context=contexto(verificar), timeout=30) as r:
        res = json.load(r)
    if not res.get("status"):
        errores = "; ".join(res.get("errors") or ["sin detalle"])[:300]
        raise RuntimeError(f"cPanel respondió con error en {funcion}: {errores}")
    return res.get("data")


def conectar():
    """Prueba el host del FTP y el del servidor; devuelve (host, verificar)."""
    candidatos = [h for h in (os.environ.get("CPANEL_HOST", ""), ZONA, "single-4020.banahosting.com") if h]
    usuario = os.environ.get("CPANEL_USER", "")
    token = os.environ.get("CPANEL_TOKEN", "")
    # Lo que se dice del usuario sin mostrarlo: el error más común es poner
    # un correo o el dominio en vez del nombre de usuario de cPanel.
    print(f"Usuario: {len(usuario)} caracteres, {'con' if '@' in usuario else 'sin'} @, "
          f"{'con' if '.' in usuario else 'sin'} punto · CPANEL_TOKEN: {len(token.strip())} caracteres ({'token' if len(token.strip()) == 32 else 'se usa como clave'})"
          f"{' (traía espacios o saltos de línea, se limpiaron)' if token != token.strip() or usuario != usuario.strip() else ''}")
    for host in dict.fromkeys(candidatos):
        for verificar in (True, False):
            try:
                llamar(host, "parse_zone", {"zone": ZONA}, verificar=verificar)
                if not verificar:
                    print(f"Aviso: el certificado de {host}:2083 no calza con el nombre; se sigue sin validarlo.")
                return host, verificar
            except urllib.error.HTTPError as e:
                print(f"{host}: HTTP {e.code} · {motivo(e)}")
                if e.code in (401, 403):
                    break
            except Exception as e:  # noqa: BLE001 — se prueba el siguiente
                print(f"{host}: {type(e).__name__} · {str(e)[:160]}")
    raise SystemExit("No se pudo entrar a la API de cPanel con ningún host (arriba, el motivo de cada uno). "
                     "Revisar los secretos CPANEL_USER (nombre de usuario de cPanel, no un correo) y "
                     "CPANEL_TOKEN (cPanel → Seguridad → Manage API Tokens).")


def motivo(error):
    """El texto con que cPanel rechaza, sin el usuario ni el token si los repite."""
    try:
        cuerpo = error.read().decode(errors="replace")
    except Exception:  # noqa: BLE001
        return "sin detalle"
    for secreto in (os.environ.get("CPANEL_USER"), os.environ.get("CPANEL_TOKEN"), os.environ.get("CPANEL_PASS")):
        if secreto:
            cuerpo = cuerpo.replace(secreto, "<oculto>")
    return " ".join(re.sub(r"<[^>]+>", " ", cuerpo).split())[:240] or "sin detalle"


def nombre(registro):
    return base64.b64decode(registro.get("dname_b64", "")).decode(errors="replace")


def valores(registro):
    return [base64.b64decode(x).decode(errors="replace") for x in registro.get("data_b64", [])]


def main():
    modo = os.environ.get("MODO", "ver")
    host, verificar = conectar()
    zona = llamar(host, "parse_zone", {"zone": ZONA}, verificar=verificar)
    soa = next(r for r in zona if r.get("record_type") == "SOA")
    serial = valores(soa)[2]

    faltan = []
    for q in QUERIDOS:
        existentes = [r for r in zona if r.get("type") == "record"
                      and nombre(r).rstrip(".") in (q["dname"], f"{q['dname']}.{ZONA}")]
        iguales = [r for r in existentes if r.get("record_type") == q["record_type"]
                   and "".join(valores(r)).rstrip(".") == "".join(q["data"]).rstrip(".")]
        if iguales:
            estado = "ya está, con el valor correcto"
        elif existentes:
            estado = f"existe con otro valor o tipo ({existentes[0].get('record_type')}): NO se toca, revisar a mano"
        else:
            estado = "falta"
            faltan.append(q)
        print(f"{q['record_type']:5} {q['dname']}.{ZONA}: {estado}")

    if modo != "agregar":
        print(f"\nModo «ver»: no se escribió nada. Faltan {len(faltan)}.")
        return
    if not faltan:
        print("\nNo hay nada que agregar.")
        return
    adds = [json.dumps({**q, "ttl": 14400}) for q in faltan]
    llamar(host, "mass_edit_zone", {"zone": ZONA, "serial": serial, "add": adds}, metodo="POST", verificar=verificar)
    print(f"\nAgregados {len(faltan)} registro(s) a {ZONA}.")


if __name__ == "__main__":
    try:
        main()
    except RuntimeError as e:
        sys.exit(str(e))
