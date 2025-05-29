import random
import datetime

first_names = ["Alice", "Mohd", "Jane", "David", "Wei Ling", "Siti", "Lucas", "Ryan", "Michelle", "Karen"]
last_names = ["Tan", "Rahim", "Lim", "Ong", "Lee", "Chong", "Yap", "Goh", "Wong", "Ng"]
cities = [("Kuching", "Sarawak"), ("Miri", "Sarawak"), ("Ipoh", "Perak"), ("Shah Alam", "Selangor"), ("Penang", "Penang"), ("Petaling Jaya", "Selangor"), ("Johor Bahru", "Johor"), ("Alor Setar", "Kedah")]
enquiry_types = ["Membership", "Products", "Pop-up Market Activities"]
messages = [
    "How do I renew my membership?",
    "Do you offer lactose-free options?",
    "Will there be a market next month?",
    "Is Cold Brew available for delivery?",
    "Can I transfer my membership to a friend?",
    "How long does shipping take?",
    "Are pets allowed at events?",
    "Can I pay by credit card?",
    "Do you have WiFi?",
    "Where can I park?"
]

for i in range(1, 16):
    fn = random.choice(first_names)
    ln = random.choice(last_names)
    city, state = random.choice(cities)
    street = f"{random.randint(1, 999)} Random St"
    postcode = str(random.randint(10000, 99999))
    phone = f"01{random.randint(0,9)}-{random.randint(1000000,9999999)}"
    email = f"{fn.lower()}.{ln.lower()}@example.com"
    eq_type = random.choice(enquiry_types)
    msg = random.choice(messages)
    ticket_id = f"ENQ-{10000 + i}"
    status = random.choice(["Pending", "In Progress", "Resolved"])
    address = f"{street}, {city}, {state}, {postcode}"
    print(f"INSERT INTO enquiry (ticket_id, first_name, last_name, email, phone, address, postcode, city, state, enquiry_type, message, status) VALUES ('{ticket_id}', '{fn}', '{ln}', '{email}', '{phone}', '{address}', '{postcode}', '{city}', '{state}', '{eq_type}', '{msg}', '{status}');")
