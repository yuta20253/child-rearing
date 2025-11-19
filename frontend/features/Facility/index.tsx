'use client';

import { RequireAuth } from '@/components/RequireAuth';
import { useState, useEffect } from 'react';
import dynamic from 'next/dynamic';
import { FacilityWithRelations } from '@/types/generated/api';
import { getFacility } from '@/libs/services/facilities';
import { FacilityHourList } from './List/FacilityHour';
import { FacilityReviewList } from './List/Review';

const Map = dynamic(() => import('./Map').then(mod => mod.Map), { ssr: false });

export const FacilityPage = ({ id }: { id: string }): React.JSX.Element => {
  const [isLoading, setIsLoading] = useState<boolean>(false);
  const [facility, setFacility] = useState<FacilityWithRelations | undefined>(undefined);

  useEffect(() => {
    const facilityId = Number(id);
    if (isNaN(facilityId)) return console.error('無効な施設IDです');
    const token = localStorage.getItem('token');
    if (!token) return;
    const fetchData = async () => {
      try {
        setIsLoading(true);

        const data = await getFacility(token, facilityId);

        if (data) {
          setFacility(data);
        }
      } catch (error) {
        console.error('施設情報の取得に失敗しました', error);
      } finally {
        setIsLoading(false);
      }
    };
    fetchData();
  }, [id]);
  return (
    <RequireAuth>
      <div className="min-h-screen mt-4">
        {!isLoading && facility ? (
          <div>
            <div className="max-w-3xl mx-auto space-y-6">
              <div className="max-w-[400px] mx-auto mt-4 text-left">
                <p className="mb-1 font-bold">🗾 地図で見る</p>
                <div className="flex space-x-2 border relative z-0 overflow-hidden rounded-lg">
                  <Map facility={facility} />
                </div>
              </div>
            </div>
            <div className="rounded-2xl p-4 space-y-3">
              <div className="text-center">
                <p className="text-2xl">🏠 {facility.name}</p>
              </div>
              <div className="mt-4 w-full max-w-md mx-auto space-y-2">
                <div className="justify-between p-2">
                  <div className="p-4">
                    <div className="text-lg font-semibold text-gray-700 mb-2">住所</div>
                    <div className="pl-1 text-gray-600">
                      {facility.address?.municipality?.prefecture?.name}
                      {facility.address?.municipality?.name}
                      {facility.address?.town}
                    </div>
                  </div>
                  <div className="p-4">
                    <h3 className="text-lg font-semibold text-gray-700 mb-2">電話番号</h3>
                    <p className="pl-1 text-gray-600">{facility.phone?.number}</p>
                  </div>
                  <div className="p-4">
                    <h3 className="text-lg font-semibold text-gray-700 mb-2">🕒 営業時間</h3>
                    <FacilityHourList facility={facility} />
                  </div>
                  <div className="p-4">
                    <h3 className="text-lg font-semibold text-gray-700 mb-2">設備情報</h3>
                    <p className="pl-1 text-gray-600">{facility.equipment}</p>
                  </div>
                </div>
                <FacilityReviewList facility={facility} />
              </div>
            </div>
          </div>
        ) : (
          <div></div>
        )}
      </div>
    </RequireAuth>
  );
};
