'use client';

import { MapContainer, TileLayer, Marker, Popup } from 'react-leaflet';
import L from 'leaflet';
import markerIcon2x from 'leaflet/dist/images/marker-icon-2x.png';
import markerIcon from 'leaflet/dist/images/marker-icon.png';
import markerShadow from 'leaflet/dist/images/marker-shadow.png';
import { Facility } from '@/types/generated/api';

delete (L.Icon.Default.prototype as unknown as { _getIconUrl?: unknown })._getIconUrl;

L.Icon.Default.mergeOptions({
  iconRetinaUrl: markerIcon2x.src,
  iconUrl: markerIcon.src,
  shadowUrl: markerShadow.src,
});

type MapProps = {
  facilities?: Facility[];
};

export const Map = ({ facilities = [] }: MapProps): React.JSX.Element => {
  const center: [number, number] = [34.74714, 135.357863]; // 一旦センターをアクタ西宮に設定

  return (
    <MapContainer
      center={center}
      zoom={10}
      scrollWheelZoom={true}
      style={{ height: '240px', width: '100%' }}
    >
      <TileLayer
        attribution="&copy; OpenStreetMap contributors"
        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
      />
      {facilities
        .filter(facility => facility.latitude !== undefined && facility.longitude !== undefined)
        .map(facility => (
          <Marker
            key={facility.id}
            position={[facility.latitude as number, facility.longitude as number]}
          >
            <Popup>📍{facility.name}</Popup>
          </Marker>
        ))}
    </MapContainer>
  );
};
