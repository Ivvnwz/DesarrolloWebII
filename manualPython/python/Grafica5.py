import pandas as pd
import matplotlib.pyplot as plt

# 1. Leer el archivo CSV
df = pd.read_csv("Ventas.csv", encoding="utf-8")

# 2. Limpiar los nombres de las columnas
df.columns = df.columns.str.strip()

# 3. Verificar que existan las columnas necesarias
columnas = ["Mes", "Producto", "Ventas", "Costos"]

if not all(columna in df.columns for columna in columnas):
    raise ValueError(
        "El CSV debe contener las columnas: Mes, Producto, Ventas y Costos"
    )

# 4. Definir el orden de los meses
orden_meses = ["Enero", "Febrero", "Marzo", "Abril"]

df["Mes"] = pd.Categorical(
    df["Mes"],
    categories=orden_meses,
    ordered=True
)

# 5. Crear tabla dinámica de ventas
tabla_ventas = df.pivot(
    index="Mes",
    columns="Producto",
    values="Ventas"
)

# 6. Crear tabla dinámica de costos
tabla_costos = df.pivot(
    index="Mes",
    columns="Producto",
    values="Costos"
)

# 7. Crear dos gráficas
fig, ejes = plt.subplots(1, 2, figsize=(14, 6))

# Gráfica de ventas
tabla_ventas.plot(
    kind="bar",
    ax=ejes[0],
    width=0.7
)

ejes[0].set_title("Ventas por producto y mes")
ejes[0].set_xlabel("Mes")
ejes[0].set_ylabel("Valor de ventas")
ejes[0].tick_params(axis="x", rotation=0)
ejes[0].legend(title="Producto")
ejes[0].grid(axis="y", linestyle="--", alpha=0.5)

# Gráfica de costos
tabla_costos.plot(
    kind="bar",
    ax=ejes[1],
    width=0.7
)

ejes[1].set_title("Costos por producto y mes")
ejes[1].set_xlabel("Mes")
ejes[1].set_ylabel("Valor de costos")
ejes[1].tick_params(axis="x", rotation=0)
ejes[1].legend(title="Producto")
ejes[1].grid(axis="y", linestyle="--", alpha=0.5)

# 8. Ajustar y mostrar
plt.tight_layout()
plt.show()

# 9. Mostrar los datos en consola
print("\nDATOS DEL ARCHIVO CSV:")
print(df.to_string(index=False))

print("\nTABLA DE VENTAS:")
print(tabla_ventas)

print("\nTABLA DE COSTOS:")
print(tabla_costos)