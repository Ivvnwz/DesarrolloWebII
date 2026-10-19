import matplotlib.pyplot as grafico

dias = [1,2,3,4,5,6,7]
temperatura = [15,16,17,18,20,19,17]

grafico.title("Temperatura de la ultima semana en popayan")
grafico.xlabel("Dias de la semana")
grafico.ylabel("Temperatura")
grafico.plot(dias,temperatura)
grafico.show()