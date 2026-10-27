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


def llamar(host, funcion, params, metodo="GET", verificar=True):
    usuario = os.environ["CPANEL_USER"]
    url = f"https://{host}:2083/execute/DNS/{funcion}"
    datos = urllib.parse.urlencode(params, doseq=True)
    if metodo == "GET":
        req = urllib.request.Request(url + "?" + datos)
    else:
        req = urllib.request.Request(url, data=datos.encode(), method="POST")
    # Con token de API de cPanel (Seguridad → Manage API Tokens) si lo hay: se
    # revoca sin cambiar la clave. Si no, usuario y clave (los del FTP, que el
    # 27-oct-2026 resultaron ser de una subcuenta: cPanel respondió 401).
    if os.environ.get("CPANEL_TOKEN"):
        req.add_header("Authorization", f"cpanel {usuario}:{os.environ['CPANEL_TOKEN']}")
    else:
        basica = base64.b64encode(f"{usuario}:{os.environ.get('CPANEL_PASS', '')}".encode()).decode()
        req.add_header("Authorization", "Basic " + basica)
    ctx = ssl.create_default_context() if verificar else ssl._create_unverified_context()
    with urllib.request.urlopen(req, context=ctx, timeout=30) as r:
        res = json.load(r)
    if not res.get("status"):
        errores = "; ".join(res.get("errors") or ["sin detalle"])[:300]
        raise RuntimeError(f"cPanel respondió con error en {funcion}: {errores}")
    return res.get("data")


def conectar():
    """Prueba el host del FTP y el del servidor; devuelve (host, verificar)."""
    candidatos = [h for h in (os.environ.get("CPANEL_HOST", ""), ZONA, "single-4020.banahosting.com") if h]
    ultimo = None
    for host in dict.fromkeys(candidatos):
        for verificar in (True, False):
            try:
                llamar(host, "parse_zone", {"zone": ZONA}, verificar=verificar)
                if not verificar:
                    print(f"Aviso: el certificado de {host}:2083 no calza con el nombre; se sigue sin validarlo.")
                return host, verificar
            except urllib.error.HTTPError as e:
                ultimo = f"{host}: HTTP {e.code}"
                if e.code in (401, 403):
                    break
            except Exception as e:  # noqa: BLE001 — se prueba el siguiente
                ultimo = f"{host}: {type(e).__name__}"
    raise SystemExit(f"No se pudo entrar a la API de cPanel ({ultimo}). Falta el token: crear uno en "
                     "cPanel → Seguridad → Manage API Tokens y guardarlo en los secretos CPANEL_USER "
                     "(usuario de cPanel) y CPANEL_TOKEN.")


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
