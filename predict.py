import joblib
import sys
import pandas as pd
import os

columns = [
    'Minutes to metro', 'Area', 'Living area', 'Kitchen area',
    'Floor', 'Number of floors', 'Number of rooms',
    'Apartment type', 'Renovation'
]

def load_model(model_code):
    model_map = {
        'DT': 'model/Apart_Price_Prediction_DT.sav',
        'RF': 'model/Apart_Price_Prediction_RF.sav',
        'KNN': 'model/Apart_Price_Prediction_KNN.sav'
    }
    model_path = model_map.get(model_code.upper())
    if not model_path or not os.path.exists(model_path):
        raise ValueError(f"Model '{model_code}' tidak ditemukan.")
    return joblib.load(model_path)

def predict_from_csv(file_path, model):
    df = pd.read_csv(file_path)
    return model.predict(df)

def predict_from_args(args, model):
    numeric = list(map(float, args[:7]))
    categorical = [arg.strip('"') for arg in args[7:]]
    df = pd.DataFrame([numeric + categorical], columns=columns)
    return model.predict(df)[0]

if __name__ == '__main__':
    try:
        model_code = sys.argv[1]
        input_type = sys.argv[2]  # 'csv' atau 'manual'

        model = load_model(model_code)

        if input_type == 'csv':
            file_path = sys.argv[3]
            preds = predict_from_csv(file_path, model)
            for price in preds:
                print(price)
        else:
            args = sys.argv[3:]
            pred = predict_from_args(args, model)
            print(pred)

    except Exception as e:
        print("ERROR:", e)
        sys.exit(1)
