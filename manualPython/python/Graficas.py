
import pandas as pd
import matplotlib.pyplot as grafica

# 1. Leer el archivo CSV usando punto y coma
datos = pd.read_csv(
    "Ventas.csv",
    sep=";",
    header=None,
    names=["Mes", "Producto", "Ventas", "Costos"]
)

# 2. Ver las primeras filas
print("Ver datos")
print(datos.head())

# 3. Información del DataFrame
print("\nInformación del DataFrame:")
datos.info()

# 4. Estadísticas
print("\nEstadísticas:")
print(datos.describe())

# 5. Crear tabla dinámica
tabla = datos.pivot(
    index="Mes",
    columns="Producto",
    values="Ventas"
)

# 6. Ordenar los meses cronológicamente
orden_meses = ["Enero", "Febrero", "Marzo", "Abril"]
tabla = tabla.reindex(orden_meses)

# 7. Crear gráfico de barras
tabla.plot(kind="bar", figsize=(10, 6))

# 8. Personalizar el gráfico
grafica.title("Ventas por producto y mes")
grafica.xlabel("Mes")
grafica.ylabel("Ventas ($)")
grafica.xticks(rotation=0)
grafica.legend(title="Producto")
grafica.grid(axis="y", linestyle="--", alpha=0.5)

grafica.tight_layout()
grafica.show()
