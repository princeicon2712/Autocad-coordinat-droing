import math

print("===================================")
print("     🌍  BM Coordinate Calculator")
print("===================================\n")

# --- 🔹 ইনপুট নেওয়া ---
lat1 = float(input("📍 Enter Latitude (e.g. 25.122426): "))
lon1 = float(input("📍 Enter Longitude (e.g. 91.377912): "))
bearing = float(input("🧭 Enter Direction (Degree): "))
dist_ft = float(input("📏 Enter Distance (Feet): "))

# --- 🔹 দূরত্বকে মিটারে রূপান্তর ---
dist_m = dist_ft * 0.3048

# --- 🔹 ধ্রুবক মান ---
R = 6371000  # পৃথিবীর ব্যাসার্ধ (মিটার)
lat1_rad = math.radians(lat1)
bearing_rad = math.radians(bearing)

# --- 🔹 Δlat এবং Δlon হিসাব ---
dlat = (dist_m * math.cos(bearing_rad)) / 111320
dlon = (dist_m * math.sin(bearing_rad)) / (111320 * math.cos(lat1_rad))

# --- 🔹 নতুন কো-অর্ডিনেট বের করা ---
lat2 = lat1 + dlat
lon2 = lon1 + dlon

# --- 🔹 আউটপুট (Bold style) ---
print("\n===================================")
print("           ✅ RESULT")
print("===================================")
print(f"📍 Original Coordinate : {lat1:.6f}, {lon1:.6f}")
print(f"📏 Distance             : {dist_ft:.2f} ft  ({dist_m:.3f} m)")
print(f"🧭 Bearing              : {bearing:.2f}°")
print("-----------------------------------")
print(f"🌐 New Coordinate       : \033[1m{lat2:.6f}, {lon2:.6f}\033[0m")
print("===================================\n")

# --- 🔹 ঐচ্ছিক Google Maps লিঙ্ক তৈরি ---
map_link = f"https://www.google.com/maps?q={lat2},{lon2}"
print(f"🔗 Google Maps Link: {map_link}")
print("===================================")
