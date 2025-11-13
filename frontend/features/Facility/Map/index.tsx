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
  facility?: Facility;
};

export const Map = ({ facility }: MapProps): React.JSX.Element => {
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
      <Marker
        key={facility?.id}
        position={[facility?.latitude as number, facility?.longitude as number]}
      >
        <Popup>📍{facility?.name}</Popup>
      </Marker>
    </MapContainer>
  );
};
