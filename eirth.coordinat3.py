import math
import re

print("===================================")
print("     🌍  BM Coordinate Calculator")
print("===================================\n")

# --- 🔹 DMS → Decimal Degree Converter ---
def dms_to_dd(deg, minutes, seconds, direction):
    dd = float(deg) + float(minutes)/60 + float(seconds)/3600
    if direction.upper() in ["S", "W"]:
        dd *= -1
    return dd

# --- 🔹 Decimal → DMS Converter ---
def to_dms(value, lat_or_lon):
    deg = int(value)
    minutes_full = abs((value - deg) * 60)
    minutes = int(minutes_full)
    seconds = (minutes_full - minutes) * 60
    direction = ""
    if lat_or_lon == "lat":
        direction = "N" if value >= 0 else "S"
    else:
        direction = "E" if value >= 0 else "W"
    return f"{abs(deg)}°{minutes:02d}'{seconds:05.2f}\"{direction}"

# --- 🔹 Parse DMS string (like 25°06'50.74"N) ---
def parse_dms(dms_str):
    pattern = r"(\d+)°(\d+)'([\d.]+)\"?([NSEW])"
    match = re.match(pattern, dms_str.strip())
    if not match:
        raise ValueError(f"Invalid DMS format: {dms_str}")
    deg, minute, second, direction = match.groups()
    return dms_to_dd(float(deg), float(minute), float(second), direction)

# --- 🔹 Input Section ---
print("Choose Coordinate Input Type:")
print("1️⃣  Decimal Degree (e.g. 25.122426, 91.377912)")
print("2️⃣  DMS Single Line (e.g. 25°06'50.74\"N, 91°22'54.38\"E)")
choice = input("👉 Enter 1 or 2: ").strip()

if choice == "2":
    dms_input = input("📍 Enter DMS Coordinate: ").strip()
    # Example: 25°06'50.74"N, 91°22'54.38"E
    parts = [p.strip() for p in dms_input.split(",")]
    lat1 = parse_dms(parts[0])
    lon1 = parse_dms(parts[1])
else:
    lat1 = float(input("📍 Enter Latitude (e.g. 25.122426): "))
    lon1 = float(input("📍 Enter Longitude (e.g. 91.377912): "))

# --- 🔹 Bearing & Distance Input ---
bearing = float(input("🧭 Enter Direction (Degree): "))
dist_ft = float(input("📏 Enter Distance (Feet): "))

# --- 🔹 Convert Distance to Meters ---
dist_m = dist_ft * 0.3048

# --- 🔹 Calculation ---
R = 6371000
lat1_rad = math.radians(lat1)
bearing_rad = math.radians(bearing)

dlat = (dist_m * math.cos(bearing_rad)) / 111320
dlon = (dist_m * math.sin(bearing_rad)) / (111320 * math.cos(lat1_rad))

lat2 = lat1 + dlat
lon2 = lon1 + dlon

# --- 🔹 Convert to DMS ---
lat2_dms = to_dms(lat2, "lat")
lon2_dms = to_dms(lon2, "lon")

# --- 🔹 Output ---
print("\n===================================")
print("           ✅ RESULT")
print("===================================")
print(f"📍 Original Coordinate : {lat1:.6f}, {lon1:.6f}")
print(f"📏 Distance             : {dist_ft:.2f} ft  ({dist_m:.3f} m)")
print(f"🧭 Bearing              : {bearing:.2f}°")
print("-----------------------------------")
print(f"🌐 New Coordinate (DD)  : \033[1m{lat2:.6f}, {lon2:.6f}\033[0m")
print(f"🌐 New Coordinate (DMS) : \033[1m{lat2_dms}, {lon2_dms}\033[0m")
print("===================================\n")

# --- 🔹 Google Maps Link ---
map_link = f"https://www.google.com/maps?q={lat2},{lon2}"
print(f"🔗 Google Maps Link: {map_link}")
print("===================================")
