import React from 'react';

type FacilityFavorite = {
  id: number;
  name: string;
};

type Props = {
  facility: FacilityFavorite
};

export const FacilityFavoriteCard = ({ facility }: Props) => {
    return (
        <div className="flex-shrink-0 w-[240px] bg-white border border-gray-300 rounded p-4 shadow ">
            <div className="flex flex-col justify-between pr-2">
                <p className="font-semibold">施設名: {facility.name}</p>
                <p className="text-sm text-yellow-500">星評価</p>
            </div>
            <div>
                <p className="text-sm text-gray-600">施設タイプ</p>
                <p className="text-sm text-gray-600 mb-2">住所</p>
            </div>
            <div className="flex justify-end">
                <button className="text-sm text-blue-600 hover:underline">詳細を見る</button>
            </div>
        </div>
    )
}
