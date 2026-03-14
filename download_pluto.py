import urllib.request
import json
import zipfile
import io

try:
    url = "https://github.com/hiteshindus/pluto-admin-dashboard/archive/refs/heads/main.zip"
    print("Downloading pluto template from", url)
    resp = urllib.request.urlopen(url)
    with zipfile.ZipFile(io.BytesIO(resp.read())) as z:
        z.extractall("public/temp_pluto")
    print("Downloaded successfully!")
except Exception as e:
    print("Could not download:", e)
    # Searching for pluto
    req = urllib.request.Request("https://api.github.com/search/repositories?q=pluto+admin+html", headers={'User-Agent': 'Mozilla/5.0'})
    resp = urllib.request.urlopen(req)
    data = json.loads(resp.read())
    for item in data['items'][:5]:
        print(item['html_url'])
