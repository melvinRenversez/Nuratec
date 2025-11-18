import requests

# --- API ---

url = "https://geo.api.gouv.fr/communes"

response = requests.get(url)
communes = response.json()

for commune in communes:
    print(f"{commune['nom']} ({commune['code']}) - {commune['codesPostaux']}")