
from fpdf import FPDF

# Datos del presupuesto
proyecto = input("Ingrese la descripción del proyecto o empresa: ")
horas_estimadas = float(
    input("Ingrese el total de horas estimadas: ").replace(",", ".")
)
valor_hora = float(
    input("Introduzca el valor de la hora trabajada: ").replace(",", ".")
)
termino = input("Introduzca el tiempo estimado de finalización: ")

valor_total = horas_estimadas * valor_hora

# Crear PDF tamaño carta
pdf = FPDF(orientation="P", unit="mm", format="Letter")
pdf.set_margins(0, 0, 0)
pdf.set_auto_page_break(auto=False)
pdf.add_page()

# Fondo: ajustar exactamente a una hoja carta
pdf.image(
    "Factura_universitaria_con_mascota_felina.png",
    x=0,
    y=0,
    w=215.9,
    h=279.4
)

# Estilo del texto
pdf.set_font("Arial", "", 11)
pdf.set_text_color(15, 43, 76)

# Posición horizontal dentro de la columna derecha
x_texto = 81
ancho_texto = 122
alto_texto = 10

# Coordenadas verticales aproximadas al centro de cada fila
filas = [
    (90, proyecto),                 # Empresa / proyecto
    (119, f"{horas_estimadas:g}"),   # Horas estimadas
    (148, f"$ {valor_hora:,.2f}"),   # Valor hora
    (177, termino),                 # Término
    (206, f"$ {valor_total:,.2f}")  # Total
]

# Escribir cada dato en su casilla
for y, texto in filas:
    pdf.set_xy(x_texto, y - alto_texto / 2)
    pdf.multi_cell(
        ancho_texto,
        5,
        texto,
        border=0,
        align="L"
    )

# Guardar archivo
pdf.output("Presupuesto.pdf")

print("¡Presupuesto generado exitosamente!")
