import pandas as pd
import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot as plt

df = pd.read_csv('datos/ventas.csv')
df.groupby('mes')['venta'].sum().plot(kind='bar', color='#0a4b8c')
plt.title('Ventas por mes')
plt.tight_layout()
plt.savefig('datos/grafica.png')