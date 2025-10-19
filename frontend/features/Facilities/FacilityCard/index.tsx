import React from 'react';
import { Facility } from '@/types/generated/api';

type Props = {
  facility: Facility;
};

export const FacilityCard = ({ facility }: Props) => {
  return (
    <div className="flex-shrink-0 w-[192px] bg-white border border-gray-300 rounded p-3 shadow ">
      <div className="space-y-2 mb-4">
        <p className="text-base font-semibold text-gray-800">{facility.name}</p>
      </div>
      <div className="flex justify-end">
        <button className="text-sm text-blue-600 hover:underline">詳細を見る</button>
      </div>
    </div>
  );
};
