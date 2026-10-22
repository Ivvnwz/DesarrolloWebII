import pandas as pd
import matplotlib.pyplot as grafica

archivo = pd.read_csv("Ventas.csv")


tabla = archivo.pivot(index= "Mes", columns="Producto", values= "Ventas")

orden_meses = ["Enero", "Febrero", "Marzo", "Abril"]
tabla = tabla.reindex(orden_meses)


tabla.plot(kind="bar", figsize=(9, 5), edgecolor="black")

grafica.title("Ventas por producto y mes")
grafica.xlabel("Mes")
grafica.ylabel("Ventas ($)")
grafica.xticks(rotation = 0)
grafica.legend(title="Producto")
grafica.tight_layout()
grafica.show()
