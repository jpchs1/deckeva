"""¿Algo de la cotización quedó debajo del pie? DOMPDF no parte la hoja cuando
el contenido se pasa: lo dibuja bajo el pie fijo, sin avisar. Esto mide, en
cada PDF que dejó matriz.php, cuánto aire queda entre lo último escrito y el
pie (34 pt). Sale en 1 si alguno tiene menos de 4 pt o más de una página."""
import sys, glob, pymupdf

PIE = 34          # alto del pie en pt (@page margin-bottom)
PADDING_CTA = 12  # el recuadro final sigue 12 pt bajo su último texto
malos, filas = 0, []
for f in sorted(glob.glob(sys.argv[1] + '/*.pdf')):
    d = pymupdf.open(f); pg = d[0]
    bloques = [b for b in pg.get_text('blocks') if 'Cotización válida' not in b[4] and 'deckeva.cl · deckeva.com' not in b[4]]
    aire = pg.rect.height - PIE - max(b[3] for b in bloques) - PADDING_CTA
    filas.append((aire, d.page_count, f.rsplit('/', 1)[-1]))
    if aire < 4 or d.page_count > 1: malos += 1
for aire, pags, nombre in sorted(filas)[:5]:
    print('aire %5.1f pt  páginas %d  %s' % (aire, pags, nombre))
print('%d de %d con problemas' % (malos, len(filas)))
sys.exit(1 if malos else 0)
