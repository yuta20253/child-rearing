import { FacilityWithRelations } from '@/types/generated/api';
import React from 'react';

type Props = {
  facility: FacilityWithRelations;
};

export const FacilityCard = ({ facility }: Props) => {
  const prefectureName = facility.address?.municipality?.prefecture?.name ?? '';
  const municipalityName = facility.address?.municipality?.name ?? '';
  const town = facility.address?.town ?? '';
  const fullAddress = prefectureName + municipalityName + town;
  return (
    <div className="flex-shrink-0 w-full bg-white border border-gray-300 rounded p-3 shadow my-2">
      <div className="space-y-2 mb-4">
        <p className="text-base font-semibold text-gray-800 break-words">{facility.name}</p>
        <p className="text-xs font-semibold text-gray-800 break-words">📍{fullAddress}</p>
      </div>
      <div className="flex justify-end">
        <a href={`/facilities/${facility.id}`} className='p-2 text-xs text-black bg-pink-200 rounded-md hover:underline'>詳細を見る</a>
      </div>
    </div>
  );
};
