import React from 'react';
import { StarRating } from '../FavoriteFacilityStarRating';

type FacilityFavorite = {
  id: number;
  name: string;
  address: string;
  rating: number;
};

type Props = {
  facility: FacilityFavorite;
};

export const FacilityFavoriteCard = ({ facility }: Props) => {
  return (
    <div className="flex-shrink-0 w-[240px] bg-white border border-gray-300 rounded p-4 shadow ">
      <div className='space-y-2 mb-4'>
        <p className='text-base font-semibold text-gray-800'>{facility.name}</p>
        <div className='flex items-center text-sm text-gray-600'>
          <span className="mr-1">星評価:</span>
          <StarRating rating={facility.rating} />
        </div>
        <p className="text-sm text-gray-500">住所: {facility.address}</p>
      </div>
      <div className="flex justify-end">
        <button className="text-sm text-blue-600 hover:underline">詳細を見る</button>
      </div>
    </div>
  );
};
