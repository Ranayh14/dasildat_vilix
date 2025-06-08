import sys
import pandas as pd
import os
import joblib

# Define columns for both manual and CSV predictions
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
        raise ValueError(f"Model '{model_code}' tidak ditemukan. Pastikan file model tersedia di folder 'model'.")
    return joblib.load(model_path)

def validate_csv_data(df):
    # Check if all required columns are present
    missing_cols = set(columns) - set(df.columns)
    if missing_cols:
        raise ValueError(f"Kolom yang hilang: {', '.join(missing_cols)}")
    
    # Validate numeric columns
    numeric_cols = columns[:7]  # All columns before apartment_type
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
        # Read CSV
        df = pd.read_csv(file_path)
        
        # Validate data
        validate_csv_data(df)
        
        # Ensure columns are in correct order for prediction
        df_features = df[columns]
        
        # Make predictions
        predictions = model.predict(df_features)
        
        # Print each prediction on a new line
        for pred in predictions:
            print(pred)
            
    except Exception as e:
        print(f"ERROR: Error dalam memproses file CSV: {str(e)}")
        sys.exit(1)

def predict_from_args(args, model):
    try:
        # Convert numeric arguments
        numeric = list(map(float, args[:7]))  # First 7 arguments are numeric
        categorical = [arg.strip('"') for arg in args[7:]]  # Last 2 are categorical
        
        # Create DataFrame with one row
        df = pd.DataFrame([numeric + categorical], columns=columns)
        
        # Validate data
        validate_csv_data(df)
        
        # Make prediction
        return model.predict(df)[0]
    except Exception as e:
        print(f"ERROR: Error dalam prediksi manual: {str(e)}")
        sys.exit(1)

if __name__ == '__main__':
    try:
        if len(sys.argv) < 3:
            print("ERROR: Argumen tidak lengkap")
            sys.exit(1)
            
        model_code = sys.argv[1]
        input_type = sys.argv[2]  # 'csv' atau 'manual'
        
        # Load model
        model = load_model(model_code)
        
        if input_type == 'csv':
            if len(sys.argv) != 4:
                print("ERROR: Format untuk CSV: python predict.py <model> csv <file_path>")
                sys.exit(1)
            file_path = sys.argv[3]
            if not os.path.exists(file_path):
                print(f"ERROR: File tidak ditemukan: {file_path}")
                sys.exit(1)
            predict_from_csv(file_path, model)
        else:
            if len(sys.argv) != 12:  # 1(script) + 1(model) + 1(type) + 9(features)
                print("ERROR: Format untuk prediksi manual: python predict.py <model> manual <9 parameter>")
                sys.exit(1)
            args = sys.argv[3:]
            pred = predict_from_args(args, model)
            print(pred)
    
    except Exception as e:
        print(f"ERROR: {str(e)}")
        sys.exit(1)
