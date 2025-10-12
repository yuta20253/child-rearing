import React from 'react';
import { FacilityFavoriteCard } from '@/features/Home/FavoriteFacilityCard';

type FacilityFavorite = {
  id: number;
  name: string;
  address: string;
  rating: number;
};

type Props = {
  facilityFavorities: FacilityFavorite[];
};

export const FavoriteFacilities = ({ facilityFavorities }: Props): React.JSX.Element => {
  return (
    <div className="w-full max-w-[700px] mx-auto mt-8">
      <p className="font-bold mb-4">お気に入り施設</p>
      {facilityFavorities.length === 0 && (
        <p className="text-center text-gray-500">お気に入り施設はありません。</p>
      )}
      {facilityFavorities.length === 1 && (
        <div className="flex justify-center">
          <FacilityFavoriteCard facility={facilityFavorities[0]} />
        </div>
      )}
      {facilityFavorities.length === 2 && (
        <div className="flex justify-center gap-6">
          {facilityFavorities.map((facilityFavority, i) => (
            <FacilityFavoriteCard key={i} facility={facilityFavority} />
          ))}
        </div>
      )}
      {facilityFavorities.length >= 3 && (
        <div className="overflow-x-auto pb-2">
          <div className="flex gap-6 min-w-fit mx-auto px-2">
            {facilityFavorities.map((facilityFavority, i) => (
              <FacilityFavoriteCard key={i} facility={facilityFavority} />
            ))}
          </div>
        </div>
      )}
    </div>
  );
};
