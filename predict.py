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

def validate_csv_data(df):
    # Check if all required columns are present
    missing_cols = set(columns) - set(df.columns)
    if missing_cols:
        raise ValueError(f"Kolom yang hilang: {', '.join(missing_cols)}")
    
    # Validate numeric columns
    numeric_cols = columns[:7]
    for col in numeric_cols:
        if not pd.to_numeric(df[col], errors='coerce').notnull().all():
            raise ValueError(f"Kolom {col} harus berisi angka")
    
    # Validate categorical columns
    apt_types = ['New building', 'Secondary']
    renovation_types = ['yes', 'no']
    
    if not df['Apartment type'].isin(apt_types).all():
        raise ValueError("Tipe Apartemen harus 'New building' atau 'Secondary'")
    if not df['Renovation'].isin(renovation_types).all():
        raise ValueError("Renovasi harus 'yes' atau 'no'")

def predict_from_csv(file_path, model):
    try:
        df = pd.read_csv(file_path)
        validate_csv_data(df)
        
        # Ensure columns are in correct order
        df = df[columns]
        
        predictions = model.predict(df)
        results = []
        
        for i, (_, row) in enumerate(df.iterrows(), 1):
            price = predictions[i-1]
            results.append(f"Data {i}:\n" + 
                         f"Menit ke Transportasi Umum: {row['Minutes to metro']}\n" +
                         f"Luas Total: {row['Area']} m²\n" +
                         f"Luas Ruang Tamu & Kamar Tidur: {row['Living area']} m²\n" +
                         f"Luas Dapur: {row['Kitchen area']} m²\n" +
                         f"Lantai: {row['Floor']}\n" +
                         f"Jumlah Lantai Gedung: {row['Number of floors']}\n" +
                         f"Jumlah Kamar: {row['Number of rooms']}\n" +
                         f"Tipe Apartemen: {row['Apartment type']}\n" +
                         f"Renovasi: {row['Renovation']}\n" +
                         f"Prediksi Harga: Rp {price:,.0f}\n")
        
        return "\n".join(results)
    except Exception as e:
        raise ValueError(f"Error dalam memproses file CSV: {str(e)}")

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
            if not os.path.exists(file_path):
                raise ValueError(f"File tidak ditemukan: {file_path}")
            result = predict_from_csv(file_path, model)
            print(result)
        else:
            args = sys.argv[3:]
            pred = predict_from_args(args, model)
            print(pred)

    except Exception as e:
        print("ERROR:", str(e))
        sys.exit(1)
