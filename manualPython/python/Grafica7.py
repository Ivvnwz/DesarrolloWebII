archivo = pdf.read_csv("Ventas.csv")

print("Primeras filas: ")

print("valores nulos por columnas: ")
print(archivo.isnull().sum())

archivo = archivo.dropna()

print("\nTipos de datos:")
print(archivo.dtypes)

print("Meses unicos:", archivo["Mes"].unique())