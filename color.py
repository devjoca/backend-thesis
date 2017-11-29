import csv, json, gpxpy.geo
from shapely.geometry import shape, Point
from shapely.geometry import mapping

input_filename = 'blank-colored.geojson'
output_filename = 'colored2.geojson'
incidents_filename = 'incidents.csv'

incidents = []

with open(incidents_filename) as f:
    ireader = csv.DictReader(f)
    for r in ireader:
        incidents.append([float(r['lat']), float(r['long'])])

def get_colour(ratio):
    green = (90, 75, 40)
    red = (0, 100, 40)
    return [int(start + ratio * (end - start)) for start, end in zip(green, red)]

def normalize(max, min, c):
    return float((c-min))/(max-min)

polys = json.load(open(input_filename))

n=0
counts=[]
print("total features {}".format(len(polys)))
for feature in polys['features']:
    n +=1
    count = 0
    polygon = shape(feature['geometry'])
    for i in incidents:
        p = polygon.centroid
        d = gpxpy.geo.haversine_distance(i[0], i[1], p.y, p.x)
        if d < 150:
            count +=1
    print(n)
    counts.append(count)


max_c = max(counts)
min_c = min(counts)
geojson = {
    "type": "FeatureCollection",
    "features": []
}

n=0
for feature in polys['features']:
    polygon = shape(feature['geometry'])
    geojson['features'].append({
        "type": "Feature",
        "": {
            "max_c": max_c,
            "min_c": min_c,
            "count": counts[n],
            "color": get_colour(normalize(max_c, min_c, counts[n]))
        },
        "geometry": mapping(polygon)
    })
    n+=1

json.dump(geojson, open(output_filename, 'w'))
