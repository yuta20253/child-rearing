'use client';

import { RequireAuth } from '@/components/RequireAuth';
import { useState, useEffect } from 'react';
import dynamic from 'next/dynamic';
import { FacilityWithRelations } from '@/types/generated/api';
import { getFacility } from '@/libs/services/facilities';
import { FacilityHourList } from './List/FacilityHour';
import { FacilityReviewList } from './List/Review';

const Map = dynamic(() => import('../../components/Map').then(mod => mod.Map), { ssr: false });

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
      <div className="min-h-screen bg-gray-50">
        <div className="max-w-md mx-auto pb-8">
          <header className="pt-6 pb-4">
            {facility && (
              <>
                <h1 className="flex items-center gap-2 text-xl font-semibold text-gray-900">
                  <span className="text-2xl">🏠</span>
                  <span className="leading-snug">{facility.name}</span>
                </h1>
              </>
            )}
          </header>

          {isLoading && (
            <div className="flex flex-col items-center justify-center py-16 text-gray-500">
              <div className="w-8 h-8 border-4 border-gray-200 border-t-gray-400 rounded-full animate-spin mb-3" />
              <p className="text-sm">施設情報を読み込み中です…</p>
            </div>
          )}

          {!isLoading && !facility && (
            <div className="py-16 text-center text-gray-500">
              <p className="text-sm font-medium mb-1">施設情報を取得できませんでした</p>
              <p className="text-xs">電波状況を確認して、もう一度お試しください。</p>
            </div>
          )}

          {!isLoading && facility && (
            <main className="space-y-4">
              <section className="bg-white rounded-2xl shadow-sm border overflow-hidden">
                <div className="px-4 pt-3 pb-2 border-b">
                  <p className="text-sm font-semibold text-gray-800 flex items-center gap-2">
                    <span className="text-lg">🗾</span>
                    <span>地図で見る</span>
                  </p>
                </div>
                <div className="h-56 relative">
                  <Map facilities={[facility]} />
                </div>
              </section>

              <section className="bg-white rounded-2xl shadow-sm border">
                <div className="divide-y">
                  <div className="px-4 py-3">
                    <h2 className="text-sm font-semibold text-gray-800 mb-1">住所</h2>
                    <p className="text-xs text-gray-600 leading-relaxed">
                      {facility.address?.municipality?.prefecture?.name}
                      {facility.address?.municipality?.name}
                      {facility.address?.town || (
                        <span className="text-gray-400">住所情報は登録されていません。</span>
                      )}
                    </p>
                  </div>

                  <div className="px-4 py-3">
                    <h2 className="text-sm font-semibold text-gray-800 mb-1">電話番号</h2>
                    {facility.phone?.number ? (
                      <a
                        href={`tel:${facility.phone.number}`}
                        className="inline-flex items-center justify-center mt-1 px-3 py-1.5 rounded-full bg-blue-50 text-xs font-medium text-blue-600"
                      >
                        {facility.phone.number}
                      </a>
                    ) : (
                      <p className="text-xs text-gray-400">電話番号は登録されていません。</p>
                    )}
                  </div>

                  <div className="px-4 py-3">
                    <h2 className="text-sm font-semibold text-gray-800 mb-2 flex items-center gap-2">
                      <span className="text-lg">🕒</span>
                      <span>営業時間</span>
                    </h2>
                    <FacilityHourList facility={facility} />
                  </div>

                  <div className="px-4 py-3">
                    <h2 className="text-sm font-semibold text-gray-800 mb-1">設備情報</h2>
                    <p className="text-xs text-gray-600 whitespace-pre-line">
                      {facility.equipment || (
                        <span className="text-gray-400">設備情報は登録されていません。</span>
                      )}
                    </p>
                  </div>
                </div>
              </section>

              <section className="bg-white rounded-2xl shadow-sm border">
                <FacilityReviewList facility={facility} />
              </section>
            </main>
          )}
        </div>
      </div>
    </RequireAuth>
  );
};
