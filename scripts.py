import random
import datetime

first_names = [
    "Alice", "Mohd", "Jane", "David", "Wei Ling", "Siti", "Lucas", "Ryan", "Michelle", "Karen"
]
last_names = [
    "Tan", "Rahim", "Lim", "Ong", "Lee", "Chong", "Yap", "Goh", "Wong", "Ng"
]
shifts = [
    "Morning", "Evening", "Night", "Flexible", "Weekend"
]
cities = [
    ("Kuching", "Sarawak"),
    ("Miri", "Sarawak"),
    ("Ipoh", "Perak"),
    ("Shah Alam", "Selangor"),
    ("Penang", "Penang"),
    ("Petaling Jaya", "Selangor"),
    ("Johor Bahru", "Johor"),
    ("Alor Setar", "Kedah")
]
statuses = ["Pending", "Accepted", "Rejected"]

for i in range(1, 16):
    fn = random.choice(first_names)
    ln = random.choice(last_names)
    city, state = random.choice(cities)
    street = f"{random.randint(1, 999)} Example Ave"
    postcode = str(random.randint(10000, 99999))
    phone = f"01{random.randint(0,9)}-{random.randint(1000000,9999999)}"
    email = f"{fn.lower()}.{ln.lower()}@example.com"
    preferred_shift = random.choice(shifts)
    address = f"{street}, {city}, {state}, {postcode}"
    photo_path = f"uploads/photos/{fn.lower()}_{ln.lower()}.jpg"
    cv_path = f"uploads/cvs/{fn.lower()}_{ln.lower()}.pdf"
    status = random.choice(statuses)
    submitted_at = (datetime.datetime.now() - datetime.timedelta(days=random.randint(0, 30))).strftime("%Y-%m-%d %H:%M:%S")

    print(f"INSERT INTO job_application (first_name, last_name, email, phone, preferred_shift, address, postcode, city, state, photo_path, cv_path, status, submitted_at) VALUES ('{fn}', '{ln}', '{email}', '{phone}', '{preferred_shift}', '{address}', '{postcode}', '{city}', '{state}', '{photo_path}', '{cv_path}', '{status}', '{submitted_at}');")
