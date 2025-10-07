import math

print("===================================")
print("     🧭 Bearing Angle Calculator")
print("===================================\n")

# --- 🔹 ইনপুট নেওয়া ---
lat1 = float(input("Enter Point 1 Latitude : "))
lon1 = float(input("Enter Point 1 Longitude: "))
lat2 = float(input("Enter Point 2 Latitude : "))
lon2 = float(input("Enter Point 2 Longitude: "))

# --- 🔹 রেডিয়ানে রূপান্তর ---
lat1_rad = math.radians(lat1)
lat2_rad = math.radians(lat2)
lon1_rad = math.radians(lon1)
lon2_rad = math.radians(lon2)

# --- 🔹 Bearing হিসাব ---
dLon = lon2_rad - lon1_rad
x = math.sin(dLon) * math.cos(lat2_rad)
y = math.cos(lat1_rad)*math.sin(lat2_rad) - math.sin(lat1_rad)*math.cos(lat2_rad)*math.cos(dLon)

bearing_rad = math.atan2(x, y)
bearing_deg = (math.degrees(bearing_rad) + 360) % 360

# --- 🔹 ফলাফল দেখানো ---
print("\n===================================")
print("           ✅ RESULT")
print("===================================")
print(f"📍 Point 1: {lat1}, {lon1}")
print(f"📍 Point 2: {lat2}, {lon2}")
print("-----------------------------------")
print(f"🧭 Bearing Angle: \033[1m{bearing_deg:.2f}°\033[0m from North")
print("===================================\n")
