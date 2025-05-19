import joblib
import sys
import pandas as pd

columns = [
    'Minutes to metro', 'Area', 'Living area', 'Kitchen area',
    'Floor', 'Number of floors', 'Number of rooms',
    'Apartment type', 'Renovation'
]

args = sys.argv[1:]

try:
    numeric = list(map(float, args[:7]))
    categorical = [arg.strip('"') for arg in args[7:]]
    df = pd.DataFrame([numeric + categorical], columns=columns)
except Exception as e:
    print("ERROR:", e)
    sys.exit(1)

model = joblib.load('model/Apart_Price_Prediction_DT.sav')

try:
    prediction = model.predict(df)[0]
    print(prediction)
except Exception as e:
    print("PREDICT ERROR:", e)
    sys.exit(1)
