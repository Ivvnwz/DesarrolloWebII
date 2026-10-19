import matplotlib.pyplot as grafica
dias = ['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo']
temperatura = [15,16,17,18,20,19,17]
#configurar el tipo de grafico
grafica.bar(dias, temperatura)
grafica.xlabel('dias de la semana')
grafica.ylabel('Temperatura')
grafica.title('Temperaturas de Popayan')
grafica.show()