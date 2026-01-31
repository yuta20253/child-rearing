import React from 'react';
import { FacilityFavoriteCard } from '@/features/Home/FavoriteFacilityCard';

type FacilityFavorite = {
  id: number;
  name: string;
  address: string;
  rating: number;
};

type Props = {
  facilityFavorites: FacilityFavorite[];
};

export const FavoriteFacilities = ({ facilityFavorites }: Props): React.JSX.Element => {
  return (
    <div className="w-full max-w-[1200px] mx-auto mt-8">
      <p className="font-bold mb-4">お気に入り施設</p>
      {facilityFavorites.length === 0 && (
        <p className="text-center text-gray-500">お気に入り施設はありません。</p>
      )}
      {facilityFavorites.length === 1 && (
        <div className="flex justify-center">
          <FacilityFavoriteCard facility={facilityFavorites[0]} />
        </div>
      )}
      {facilityFavorites.length >= 2 && (
        <div className="overflow-x-auto pb-2">
          <div className="flex gap-6 min-w-fit mx-auto px-2">
            {facilityFavorites.map((facilityFavority, i) => (
              <FacilityFavoriteCard key={i} facility={facilityFavority} />
            ))}
          </div>
        </div>
      )}
    </div>
  );
};
