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
    <div className="flex-shrink-0 w-[240px] bg-white border border-gray-300 rounded px-2 shadow ">
      <div className="flex flex-col justify-between pr-2">
        <p className="text-sm">施設名: {facility.name}</p>
        <p className="text-sm">
          星評価: <StarRating rating={facility.rating} />
        </p>
      </div>
      <div>
        <p className="text-sm mb-2">住所: {facility.address}</p>
      </div>
      <div className="flex justify-end">
        <button className="text-sm text-blue-600 hover:underline">詳細を見る</button>
      </div>
    </div>
  );
};
