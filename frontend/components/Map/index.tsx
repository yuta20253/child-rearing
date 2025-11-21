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
  const facilityList = Array.isArray(facilities) ? facilities : [facilities];
  let center: [number, number] = [34.74714, 135.357863];

  if (facilityList.length === 1) {
    center = [facilityList[0].latitude as number, facilityList[0].longitude as number];
  }

  return (
    <MapContainer
      key={
        facilityList.length === 1 ? `single-${facilityList[0].id}` : `len-${facilityList.length}`
      }
      center={center}
      zoom={10}
      scrollWheelZoom={true}
      style={{ height: '240px', width: '100%' }}
    >
      <TileLayer
        attribution="&copy; OpenStreetMap contributors"
        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
      />
      {facilityList
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
