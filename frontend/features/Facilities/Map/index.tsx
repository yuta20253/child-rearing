'use client';

import { MapContainer, TileLayer, Marker, Popup, GeoJSON } from "react-leaflet";
import type { FeatureCollection, Polygon } from 'geojson';
import L from 'leaflet';
import markerIcon2x from 'leaflet/dist/images/marker-icon-2x.png';
import markerIcon from 'leaflet/dist/images/marker-icon.png';
import markerShadow from 'leaflet/dist/images/marker-shadow.png';
import 'leaflet/dist/leaflet.css';
import { Facility } from "@/types/generated/api";

delete (L.Icon.Default.prototype as unknown as { _getIconUrl?: unknown })._getIconUrl;

L.Icon.Default.mergeOptions({
  iconRetinaUrl: markerIcon2x.src,
  iconUrl: markerIcon.src,
  shadowUrl: markerShadow.src,
});

type MapProps = {
  facilities?: Facility[];
}

// 一旦サンプルをコピーしてきた。
const geoJsonData: FeatureCollection<Polygon> = {
  type: 'FeatureCollection',
  features: [
    {
      type: 'Feature',
      properties: { name: 'サンプルエリア' },
      geometry: {
        type: 'Polygon',
        coordinates: [
          [
            [139.75, 35.68],
            [139.76, 35.68],
            [139.76, 35.69],
            [139.75, 35.69],
            [139.75, 35.68],
          ],
        ],
      },
    },
  ],
};

export const Map = ({ facilities = [] }: MapProps):React.JSX.Element => {
    const center: [number, number] = [34.74714, 135.3578630]; // 一旦センターをアクタ西宮未設定

    return (
        <MapContainer center={center} zoom={10} scrollWheelZoom={true} style={{ height: '240px', width: '100%' }} >
            <TileLayer attribution="&copy; OpenStreetMap contributors" url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" />
            {
              facilities.filter((facility) => facility.latitude !== undefined && facility.longitude !== undefined)
                        .map((facility) => (
                          <Marker key={facility.id} position={[facility.latitude as number, facility.longitude as number]}>
                              <Popup>📍{facility.name}</Popup>
                          </Marker>
              ))
            }
            <GeoJSON data={geoJsonData} />
        </MapContainer>
    );
};
