import math
import os

# রঙের কোড
RED_BOLD = "\033[1;31m"
GREEN_BOLD = "\033[1;32m"
YELLOW_BOLD = "\033[1;33m"
RESET = "\033[0m"

# ফাইল লোকেশন
save_path = "/data/data/com.termux/files/home/coordinate.txt"

# ---- আগের coordinate চেক ----
if os.path.exists(save_path):
    with open(save_path, "r") as file:
        lines = file.readlines()
        if lines:
            last_line = lines[-1].strip()
            try:
                # আগের X, Y বের করা
                last_x = float(last_line.split("X:")[1].split(",")[0].strip())
                last_y = float(last_line.split("Y:")[1].strip())
                print(f"{YELLOW_BOLD}Last saved coordinates found!{RESET}")
                print(f"{RED_BOLD}X (SIN add): {last_x}{RESET}")
                print(f"{RED_BOLD}Y (COS add): {last_y}{RESET}")
                use_prev = input(f"\nUse these as add coordinates? (y/n): ").lower()
                if use_prev == 'y':
                    add_sin = last_x
                    add_cos = last_y
                else:
                    add_sin = float(input("Enter add coordinate for SIN (X): "))
                    add_cos = float(input("Enter add coordinate for COS (Y): "))
            except:
                add_sin = float(input("Enter add coordinate for SIN (X): "))
                add_cos = float(input("Enter add coordinate for COS (Y): "))
        else:
            add_sin = float(input("Enter add coordinate for SIN (X): "))
            add_cos = float(input("Enter add coordinate for COS (Y): "))
else:
    add_sin = float(input("Enter add coordinate for SIN (X): "))
    add_cos = float(input("Enter add coordinate for COS (Y): "))

# ---- Common Input ----
deg = float(input("Enter degree: "))
distance = float(input("Enter distance: "))

# ---- রেডিয়ান কনভার্ট ----
radian = math.radians(deg)

# ---- হিসাব ----
X = math.sin(radian) * distance + add_sin
Y = math.cos(radian) * distance + add_cos

# ---- ফলাফল ----
print(f"\n{GREEN_BOLD}Results:{RESET}")
print(f"{RED_BOLD}X = {X:.6f}{RESET}")
print(f"{RED_BOLD}Y = {Y:.6f}{RESET}")

# ---- Save permission ----
save_permission = input(f"\n{YELLOW_BOLD}Do you want to save this coordinate? (y/n): {RESET}")

if save_permission.lower() == 'y':
    with open(save_path, "a") as file:
        file.write(f"Degree: {deg}, Distance: {distance}, X: {X:.6f}, Y: {Y:.6f}\n")
    print(f"{GREEN_BOLD}Coordinate saved to: {save_path}{RESET}")
else:
    print(f"{YELLOW_BOLD}Coordinate not saved.{RESET}")
