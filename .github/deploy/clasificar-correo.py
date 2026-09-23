#!/usr/bin/env python3
"""Dice qué tipo de correo es un archivo de la casilla interna del hosting.

Lo usa diagnostico.sh para saber si un correo que llegó a ~/mail es un rebote,
el aviso de cPanel de que se superó el límite de correos por hora, u otra cosa.
Los rebotes traen el correo original con datos del cliente y el log de Actions
es público, así que imprime una sola línea con el tipo y, como mucho, números.

Uso: clasificar-correo.py archivo
"""
import email
import email.policy
import re
import sys

REBOTE_REMITENTE = re.compile(r'mailer-daemon|postmaster|mail delivery', re.IGNORECASE)
LIMITE = re.compile(
    r'exceeded the max(imum)? (number of )?e-?mails? per hour'
    r'|max(imum)? (number of )?e-?mails? per hour'
    r'|l[íi]mite de correos por hora',
    re.IGNORECASE,
)
# cPanel pone el conteo como "(25/25 (100%))".
CONTEO = re.compile(r'\((\d{1,5})\s*/\s*(\d{1,5})')


def texto_legible(msj):
    partes = []
    for parte in msj.walk():
        if parte.get_content_maintype() != 'text':
            continue
        try:
            partes.append(parte.get_content())
        except Exception:
            carga = parte.get_payload(decode=True) or b''
            partes.append(carga.decode('utf-8', 'replace'))
    return '\n'.join(partes)


def clasificar(ruta):
    with open(ruta, 'rb') as f:
        msj = email.message_from_binary_file(f, policy=email.policy.default)
    # Un rebote llega con el sobre vacío: "Return-path: <>".
    sobre = msj.get('Return-Path')
    sobre_vacio = sobre is not None and str(sobre).strip() in ('<>', '')
    de = str(msj.get('From', ''))
    asunto = str(msj.get('Subject', ''))
    cuerpo = texto_legible(msj)

    if sobre_vacio or REBOTE_REMITENTE.search(de):
        if re.search(r'@example\.com\b', cuerpo, re.IGNORECASE):
            return 'rebote de una prueba a example.com'
        return 'rebote'

    if LIMITE.search(asunto) or LIMITE.search(cuerpo):
        conteo = CONTEO.search(asunto + '\n' + cuerpo)
        if conteo:
            return 'aviso del hosting: límite de correos por hora superado (%s/%s)' % conteo.groups()
        return 'aviso del hosting: límite de correos por hora superado'

    return 'otro aviso (no es rebote)'


if __name__ == '__main__':
    if len(sys.argv) != 2:
        print('Uso: clasificar-correo.py archivo')
        sys.exit(2)
    try:
        print(clasificar(sys.argv[1]))
    except Exception:
        print('no se pudo leer')
