#lista para analizar
import matplotlib.pyplot as grafica
#CARGAR INFORMACION
horas_estudio =[1,2,3,4,5,6,7,8]
nota_examen =[3,5,4,2,1,5,4,7]
# GRAFICO MAPA DE CALOR
grafica.scatter(horas_estudio, nota_examen)

grafica.xlabel('Horas de estudio')
grafica.ylabel('Nota obtenida')
grafica.title('Relacion de horas')
grafica.show()
