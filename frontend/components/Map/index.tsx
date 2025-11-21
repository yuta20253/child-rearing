'use client';

import { MapContainer, TileLayer, Marker, Popup } from 'react-leaflet';
import L from 'leaflet';
import { Facility } from '@/types/generated/api';

L.Icon.Default.mergeOptions({
  iconRetinaUrl: '/images/leaflet/marker-icon-2x.png',
  iconUrl: '/images/leaflet/marker-icon.png',
  shadowUrl: '/images/leaflet/marker-shadow.png',
});

type MapProps = {
  facilities?: Facility[];
};

export const Map = ({ facilities = [] }: MapProps): React.JSX.Element => {
  let center: [number, number] = [34.74714, 135.357863];

  if (facilities.length === 1) {
    center = [facilities[0].latitude as number, facilities[0].longitude as number];
  }

  return (
    <MapContainer
      key={facilities.length === 1 ? `single-${facilities[0].id}` : `len-${facilities.length}`}
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
