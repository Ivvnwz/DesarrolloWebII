"""
Análisis del clima diario de Popayán.

Uso:  python analisis_clima.py <archivo.csv> <carpeta_salida>

Lee el CSV descargado desde la API (api/clima_popayan.php) con pandas,
genera 6 gráficas con matplotlib (líneas, barras, histograma, dispersión,
torta y mapa de calor) y escribe un resumen.json con los indicadores.
"""
import json
import os
import sys

carpeta = sys.argv[2] if len(sys.argv) > 2 else 'datos'
# matplotlib necesita una carpeta con permisos de escritura para su caché
os.environ.setdefault('MPLCONFIGDIR', os.path.join(carpeta, '.matplotlib'))

# OpenBLAS (usado por numpy/pandas) reserva memoria para un hilo por núcleo al arrancar;
# lanzado desde Apache esa reserva a veces falla ("Memory allocation still failed").
# Con un solo hilo sobra para 365 filas y el arranque es estable.
for variable in ('OPENBLAS_NUM_THREADS', 'OMP_NUM_THREADS', 'MKL_NUM_THREADS'):
    os.environ.setdefault(variable, '1')

import numpy
import pandas as pd
import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot as grafica

# ------------------------------------------------------------------
# Paleta y estilo (la misma de la página)
# ------------------------------------------------------------------
COLOR_MAX = '#C0392B'
COLOR_MEDIA = '#E08A1E'
COLOR_MIN = '#1F5F99'
COLOR_LLUVIA = '#2A9D8F'
RAMPA_LLUVIA = ['#CDEBE6', '#7CC6BA', '#2A9D8F', '#1B6A60']
TEXTO = '#1E2733'
TEXTO_SUAVE = '#6B7684'
REJILLA = '#E3E7ED'

MESES = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
         'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
MESES_LARGOS = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio',
                'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre']

grafica.rcParams.update({
    'font.family': ['Segoe UI', 'DejaVu Sans'],
    'font.size': 10,
    'text.color': TEXTO,
    'axes.labelcolor': TEXTO_SUAVE,
    'axes.edgecolor': REJILLA,
    'axes.titlesize': 13,
    'axes.titleweight': 'bold',
    'axes.titlelocation': 'left',
    'axes.titlepad': 14,
    'axes.spines.top': False,
    'axes.spines.right': False,
    'axes.grid': True,
    'axes.axisbelow': True,
    'grid.color': REJILLA,
    'grid.linewidth': 0.8,
    'xtick.color': TEXTO_SUAVE,
    'ytick.color': TEXTO_SUAVE,
    'legend.frameon': False,
    'figure.facecolor': 'white',
    'savefig.dpi': 150,
})


def guardar(figura, nombre):
    figura.tight_layout()
    figura.savefig(os.path.join(carpeta, nombre))
    grafica.close(figura)


def nombre_mes(periodo):
    return f'{MESES_LARGOS[periodo.month - 1]} de {periodo.year}'


def fecha_larga(fecha):
    return f'{fecha.day} de {MESES_LARGOS[fecha.month - 1]} de {fecha.year}'


def numero(valor, decimales=1):
    # Formato colombiano: punto para miles y coma para decimales
    texto = f'{valor:,.{decimales}f}'
    return texto.replace(',', '_').replace('.', ',').replace('_', '.')


# ------------------------------------------------------------------
# 1. Leer y limpiar los datos
# ------------------------------------------------------------------
archivo = sys.argv[1] if len(sys.argv) > 1 else 'datos/clima.csv'
datos = pd.read_csv(archivo, encoding='utf-8-sig')
datos['fecha'] = pd.to_datetime(datos['fecha'], errors='coerce')
datos = datos.dropna(subset=['fecha', 'temp_media_c']).sort_values('fecha')
datos['mes'] = datos['fecha'].dt.to_period('M')
datos['precipitacion_mm'] = datos['precipitacion_mm'].fillna(0)

os.makedirs(carpeta, exist_ok=True)

# ------------------------------------------------------------------
# Gráfica 1 - Líneas: evolución de la temperatura (media móvil de 7 días)
# ------------------------------------------------------------------
suave = datos.set_index('fecha')[['temp_max_c', 'temp_media_c', 'temp_min_c']] \
    .rolling(7, min_periods=1).mean()

figura, ejes = grafica.subplots(figsize=(9, 4.5))
series = [('temp_max_c', 'Máxima', COLOR_MAX),
          ('temp_media_c', 'Media', COLOR_MEDIA),
          ('temp_min_c', 'Mínima', COLOR_MIN)]
for columna, etiqueta, color in series:
    ejes.plot(suave.index, suave[columna], color=color, linewidth=2, label=etiqueta)
    # Etiqueta directa al final de cada línea
    ejes.annotate(f'{etiqueta} {suave[columna].iloc[-1]:.1f} °C',
                  xy=(suave.index[-1], suave[columna].iloc[-1]),
                  xytext=(6, 0), textcoords='offset points',
                  va='center', fontsize=9, color=TEXTO)
ejes.set_title('Evolución de la temperatura diaria (media móvil de 7 días)')
ejes.set_ylabel('Temperatura (°C)')
ejes.grid(axis='x', visible=False)
ejes.legend(loc='upper left', ncol=3)
ejes.margins(x=0)
ejes.set_xlim(right=suave.index[-1] + pd.Timedelta(days=55))
ejes.xaxis.set_major_formatter(matplotlib.dates.DateFormatter('%m/%y'))
guardar(figura, 'grafica1_temperatura.png')

# ------------------------------------------------------------------
# Gráfica 2 - Barras: precipitación total por mes
# ------------------------------------------------------------------
lluvia_mes = datos.groupby('mes')['precipitacion_mm'].sum()
etiquetas = [f'{MESES[p.month - 1]}\n{str(p.year)[2:]}' for p in lluvia_mes.index]

figura, ejes = grafica.subplots(figsize=(9, 4.5))
barras = ejes.bar(etiquetas, lluvia_mes.values, color=COLOR_LLUVIA,
                  width=0.72, edgecolor='white', linewidth=2)
posicion_max = int(lluvia_mes.values.argmax())
ejes.bar_label(barras, labels=[f'{v:.0f} mm' if i == posicion_max else ''
                               for i, v in enumerate(lluvia_mes.values)],
               padding=4, fontsize=9, color=TEXTO)
ejes.set_title('Precipitación total por mes')
ejes.set_ylabel('Precipitación (mm)')
ejes.grid(axis='x', visible=False)
guardar(figura, 'grafica2_lluvia_mensual.png')

# ------------------------------------------------------------------
# Gráfica 3 - Histograma: distribución de la temperatura media
# ------------------------------------------------------------------
promedio = datos['temp_media_c'].mean()

figura, ejes = grafica.subplots(figsize=(9, 4.5))
ejes.hist(datos['temp_media_c'], bins=16, color=COLOR_MIN,
          edgecolor='white', linewidth=2)
ejes.axvline(promedio, color=TEXTO, linewidth=1.5, linestyle='--')
ejes.annotate(f'Promedio {promedio:.1f} °C', xy=(promedio, 1), xycoords=('data', 'axes fraction'),
              xytext=(6, -14), textcoords='offset points', fontsize=9, color=TEXTO)
ejes.set_title('Distribución de la temperatura media diaria')
ejes.set_xlabel('Temperatura media (°C)')
ejes.set_ylabel('Número de días')
ejes.grid(axis='x', visible=False)
guardar(figura, 'grafica3_histograma.png')

# ------------------------------------------------------------------
# Gráfica 4 - Dispersión: humedad vs temperatura media
# ------------------------------------------------------------------
pares = datos.dropna(subset=['humedad_pct'])
correlacion = pares['humedad_pct'].corr(pares['temp_media_c'])
# Recta de tendencia (regresión lineal simple)
pendiente, intercepto = numpy.polyfit(pares['humedad_pct'], pares['temp_media_c'], 1)

figura, ejes = grafica.subplots(figsize=(9, 4.5))
ejes.scatter(pares['humedad_pct'], pares['temp_media_c'], s=28, color=COLOR_MEDIA,
             alpha=0.75, edgecolors='white', linewidths=1)
x = pd.Series([pares['humedad_pct'].min(), pares['humedad_pct'].max()])
ejes.plot(x, pendiente * x + intercepto, color=TEXTO, linewidth=1.5, linestyle='--')
ejes.set_title(f'Humedad relativa vs temperatura media  (r = {numero(correlacion, 2)})')
ejes.set_xlabel('Humedad relativa media (%)')
ejes.set_ylabel('Temperatura media (°C)')
guardar(figura, 'grafica4_dispersion.png')

# ------------------------------------------------------------------
# Gráfica 5 - Torta: días según la intensidad de la lluvia
# ------------------------------------------------------------------
categorias = pd.cut(datos['precipitacion_mm'], bins=[-0.1, 1, 5, 20, float('inf')],
                    labels=['Seco (< 1 mm)', 'Ligera (1-5 mm)',
                            'Moderada (5-20 mm)', 'Fuerte (> 20 mm)'])
conteo = categorias.value_counts().reindex(categorias.cat.categories).fillna(0).astype(int)

figura, ejes = grafica.subplots(figsize=(9, 4.5))
ejes.pie(conteo.values, colors=RAMPA_LLUVIA, startangle=90, counterclock=False,
         wedgeprops={'width': 0.42, 'edgecolor': 'white', 'linewidth': 2},
         autopct=lambda p: f'{p:.0f}%' if p >= 3 else '', pctdistance=0.79,
         textprops={'color': TEXTO, 'fontsize': 9})
ejes.text(0, 0, f'{len(datos)}\ndías', ha='center', va='center', fontsize=14, fontweight='bold')
ejes.legend([f'{c}: {n} días' for c, n in conteo.items()],
            loc='center left', bbox_to_anchor=(1, 0.5))
ejes.set_title('Días según la intensidad de la lluvia')
ejes.axis('equal')
guardar(figura, 'grafica5_dias_lluvia.png')

# ------------------------------------------------------------------
# Gráfica 6 - Mapa de calor: temperatura media por mes (filas) y día (columnas)
# ------------------------------------------------------------------
calor = datos.pivot_table(index='mes', columns=datos['fecha'].dt.day,
                          values='temp_media_c', aggfunc='mean')
calor = calor.reindex(columns=range(1, 32))
temp_mes = datos.groupby('mes')['temp_media_c'].mean()
mes_calido = temp_mes.idxmax()
mes_fresco = temp_mes.idxmin()

# Escala secuencial de un solo tono (claro = fresco, oscuro = cálido)
escala = matplotlib.colors.LinearSegmentedColormap.from_list(
    'calor', ['#FDF3E6', '#F5C98A', '#E08A1E', '#B4531A', '#6E2A10'])
escala.set_bad('white')

figura, ejes = grafica.subplots(figsize=(9, 4.5))
malla = ejes.pcolormesh(calor.columns, range(len(calor.index)), calor.values,
                        cmap=escala, edgecolors='white', linewidth=1.5, shading='nearest')
ejes.set_yticks(range(len(calor.index)))
ejes.set_yticklabels([f'{MESES[p.month - 1]} {str(p.year)[2:]}' for p in calor.index])
ejes.invert_yaxis()
ejes.set_xticks([1, 5, 10, 15, 20, 25, 31])
ejes.set_xlabel('Día del mes')
ejes.grid(False)
ejes.tick_params(length=0)
for borde in ejes.spines.values():
    borde.set_visible(False)
barra = figura.colorbar(malla, ax=ejes, fraction=0.035, pad=0.02)
barra.set_label('Temperatura media (°C)')
barra.outline.set_visible(False)
barra.ax.tick_params(length=0)
ejes.set_title('Mapa de calor: temperatura media por día')
guardar(figura, 'grafica6_mapa_calor.png')

# ------------------------------------------------------------------
# Resumen para el reporte
# ------------------------------------------------------------------
dia_caluroso = datos.loc[datos['temp_max_c'].idxmax()]
dia_frio = datos.loc[datos['temp_min_c'].idxmin()]
mes_lluvioso = lluvia_mes.idxmax()
mes_seco = lluvia_mes.idxmin()
dias_lluvia = int((datos['precipitacion_mm'] >= 1).sum())

if correlacion <= -0.3:
    relacion = 'los días más húmedos tienden a ser más frescos'
elif correlacion >= 0.3:
    relacion = 'los días más húmedos tienden a ser más cálidos'
else:
    relacion = 'la humedad y la temperatura casi no se relacionan'

resumen = {
    'fecha_inicio': datos['fecha'].min().strftime('%Y-%m-%d'),
    'fecha_fin': datos['fecha'].max().strftime('%Y-%m-%d'),
    'dias': int(len(datos)),
    'temp_media': round(float(promedio), 1),
    'temp_max': round(float(dia_caluroso['temp_max_c']), 1),
    'temp_max_fecha': dia_caluroso['fecha'].strftime('%Y-%m-%d'),
    'temp_min': round(float(dia_frio['temp_min_c']), 1),
    'temp_min_fecha': dia_frio['fecha'].strftime('%Y-%m-%d'),
    'lluvia_total': round(float(datos['precipitacion_mm'].sum()), 1),
    'dias_lluvia': dias_lluvia,
    'mes_lluvioso': nombre_mes(mes_lluvioso),
    'mes_lluvioso_mm': round(float(lluvia_mes.max()), 1),
    'mes_seco': nombre_mes(mes_seco),
    'mes_seco_mm': round(float(lluvia_mes.min()), 1),
    'humedad_media': round(float(pares['humedad_pct'].mean()), 1),
    'correlacion': round(float(correlacion), 2),
    'dias_por_categoria': {str(c): int(n) for c, n in conteo.items()},
    'meses': [
        {'mes': nombre_mes(periodo), 'dias': int(len(grupo)),
         'temp_media': round(float(grupo['temp_media_c'].mean()), 1),
         'temp_max': round(float(grupo['temp_max_c'].max()), 1),
         'temp_min': round(float(grupo['temp_min_c'].min()), 1),
         'lluvia': round(float(grupo['precipitacion_mm'].sum()), 1)}
        for periodo, grupo in datos.groupby('mes')
    ],
    'graficas': [
        {'archivo': 'grafica1_temperatura.png', 'titulo': 'Evolución de la temperatura',
         'descripcion': 'Tendencia de las temperaturas máxima, media y mínima suavizada con una media móvil de 7 días.'},
        {'archivo': 'grafica2_lluvia_mensual.png', 'titulo': 'Precipitación mensual',
         'descripcion': f'El mes más lluvioso fue {nombre_mes(mes_lluvioso)} con {numero(lluvia_mes.max(), 0)} mm.'},
        {'archivo': 'grafica3_histograma.png', 'titulo': 'Distribución de la temperatura media',
         'descripcion': f'La mayoría de los días se concentran alrededor de {numero(promedio)} °C.'},
        {'archivo': 'grafica4_dispersion.png', 'titulo': 'Humedad vs temperatura',
         'descripcion': f'Correlación r = {numero(correlacion, 2)}: {relacion}.'},
        {'archivo': 'grafica5_dias_lluvia.png', 'titulo': 'Intensidad de la lluvia',
         'descripcion': f'{dias_lluvia} de {len(datos)} días registraron al menos 1 mm de lluvia.'},
        {'archivo': 'grafica6_mapa_calor.png', 'titulo': 'Mapa de calor de la temperatura',
         'descripcion': f'Cada celda es un día: {nombre_mes(mes_calido)} fue el mes más cálido '
                        f'({numero(temp_mes.max())} °C de media) y {nombre_mes(mes_fresco)} '
                        f'el más fresco ({numero(temp_mes.min())} °C).'},
    ],
}

resumen['texto'] = (
    f"Entre el {fecha_larga(datos['fecha'].min())} y el {fecha_larga(datos['fecha'].max())} "
    f"({resumen['dias']} días), Popayán registró una temperatura media de {numero(promedio)} °C. "
    f"El día más caluroso fue el {fecha_larga(dia_caluroso['fecha'])} con "
    f"{numero(dia_caluroso['temp_max_c'])} °C y la mínima más baja fue de "
    f"{numero(dia_frio['temp_min_c'])} °C el {fecha_larga(dia_frio['fecha'])}. "
    f"Llovieron {numero(resumen['lluvia_total'], 0)} mm en total, con {dias_lluvia} días de lluvia; "
    f"{nombre_mes(mes_lluvioso)} fue el mes más lluvioso ({numero(lluvia_mes.max(), 0)} mm) y "
    f"{nombre_mes(mes_seco)} el más seco ({numero(lluvia_mes.min(), 0)} mm). "
    f"La humedad relativa promedio fue de {numero(resumen['humedad_media'])} % y {relacion}."
)

with open(os.path.join(carpeta, 'resumen.json'), 'w', encoding='utf-8') as salida:
    json.dump(resumen, salida, ensure_ascii=False, indent=2)

print('OK')
