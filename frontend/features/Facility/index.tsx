'use client';

import { RequireAuth } from '@/components/RequireAuth';
import { useState, useEffect } from 'react';
import { FacilityWithRelations } from '@/types/generated/api';
import { getFacility } from '@/libs/services/facilities';
import { FacilityHourList } from './List/FacilityHour';
import { FacilityReviewList } from './List/Review';
import { Map } from '@/components/Map';
import { FaRegStar } from 'react-icons/fa';
import { FaStar } from 'react-icons/fa';
import { cancelFacilityFavorite, registerFacilityFavorite } from '@/libs/services/favorite';

export const FacilityPage = ({ id }: { id: string }): React.JSX.Element => {
  const [isLoading, setIsLoading] = useState<boolean>(false);
  const [isUpdatingFavorite, setIsUpdatingFavorite] = useState(false);
  const [facility, setFacility] = useState<FacilityWithRelations | undefined>(undefined);
  const [isFavorite, setIsFavorite] = useState<boolean>(false);
  const [message, setMessage] = useState<string | null>(null);

  useEffect(() => {
    const facilityId = Number(id);
    if (isNaN(facilityId)) return console.error('無効な施設IDです');
    const token = localStorage.getItem('token');
    if (!token) return;
    const fetchData = async () => {
      try {
        setIsLoading(true);

        const { facilityDetail, isFavorite } = await getFacility(token, facilityId);

        if (facilityDetail) {
          setFacility(facilityDetail);
          setIsFavorite(isFavorite);
        }
      } catch (error) {
        console.error('施設情報の取得に失敗しました', error);
      } finally {
        setIsLoading(false);
      }
    };
    fetchData();
  }, [id]);

  const handleChangeFavoriteStatus = async () => {
    const token = localStorage.getItem('token');
    const facilityId = facility?.id;
    if (!token || facilityId == null) return;

    const prev = isFavorite;
    setIsUpdatingFavorite(true);
    setIsFavorite(!prev);

    try {
      const message = prev
        ? await cancelFacilityFavorite(token, facilityId)
        : await registerFacilityFavorite(token, facilityId);

      setMessage(message ?? null);
    } catch (e) {
      setIsFavorite(prev);
      setMessage(e instanceof Error ? e.message : 'お気に入りの変更に失敗しました');
    } finally {
      setIsUpdatingFavorite(false);
    }
  };

  return (
    <RequireAuth>
      <div className="min-h-screen bg-gray-50">
        <div className="max-w-md mx-auto pb-8">
          <header className="flex pt-6 pb-4">
            {facility && (
              <>
                <h1 className="flex items-center gap-2 text-xl font-semibold text-gray-900 flex-shrink-0">
                  <span className="text-2xl">🏠</span>
                  <span className="leading-snug">{facility.name}</span>
                </h1>
                <button
                  className="ml-auto gap-1 mr-4 text-3xl font-semibold cursor-pointer p-2 rounded-full hover:bg-gray-200"
                  disabled={isUpdatingFavorite}
                  onClick={handleChangeFavoriteStatus}
                >
                  {isFavorite ? (
                    <FaStar className="text-yellow-400" size="1.2em" />
                  ) : (
                    <FaRegStar size="1.2em" />
                  )}
                </button>
              </>
            )}
          </header>

          {isLoading && (
            <div className="flex flex-col items-center justify-center py-16 text-gray-500">
              <div className="w-8 h-8 border-4 border-gray-200 border-t-gray-400 rounded-full animate-spin mb-3" />
              <p className="text-sm">施設情報を読み込み中です…</p>
            </div>
          )}
          {message && (
            <div className="relative mx-4 mb-3 rounded-lg border border-gray-200 bg-white px-3 py-2 pr-8 text-sm text-gray-700 shadow-sm">
              {message}
              <button
                onClick={() => setMessage(null)}
                className="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
              >
                ×
              </button>
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
              {!facility.events || facility.events.length === 0 ? (
                <section className="bg-white rounded-2xl shadow-sm border px-4 py-3">
                  <p className="text-sm font-semibold text-gray-800 mb-1">📭 イベント情報</p>
                  <p className="text-sm text-gray-500">近日開催のイベントはありません</p>
                </section>
              ) : (
                <section className="bg-white rounded-2xl shadow-sm border px-4 py-3">
                  <p className="text-sm font-semibold text-gray-800 mb-2">🎉 直近イベント</p>
                  <div className="flex items-center justify-between gap-3">
                    <p className="text-sm font-semibold text-gray-900 truncate">
                      {facility.events[0].title}
                    </p>
                    <p className="text-xs text-blue-600 font-medium whitespace-nowrap">
                      {new Date(facility.events[0].start_datetime).toLocaleDateString('ja-JP', {
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                        weekday: 'short',
                        hour: '2-digit',
                        minute: '2-digit',
                      })}
                    </p>
                  </div>
                </section>
              )}
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

              {facility.events && facility.events.length !== 0 && (
                <section className="bg-white rounded-2xl shadow-sm border overflow-hidden">
                  <div className="px-4 py-3 border-b bg-gray-50">
                    <h2 className="text-sm font-semibold text-gray-800 flex items-center gap-2">
                      <span className="text-base">📅</span>
                      <span>イベント情報</span>
                    </h2>
                  </div>
                  <div className="divide-y">
                    {facility.events?.map(event => (
                      <div
                        key={event.id}
                        className="px-4 py-3 flex items-start justify-between gap-3 hover:bg-gray-50 transition"
                      >
                        <div className="min-w-0">
                          <p className="text-sm font-semibold text-gray-900 truncate">
                            {event.title}
                          </p>
                        </div>

                        <p className="text-xs text-blue-600 font-medium whitespace-nowrap text-right leading-relaxed">
                          {new Date(event.start_datetime).toLocaleDateString('ja-JP', {
                            year: 'numeric',
                            month: '2-digit',
                            day: '2-digit',
                            weekday: 'short',
                            hour: '2-digit',
                            minute: '2-digit',
                          })}
                        </p>
                      </div>
                    ))}
                  </div>
                </section>
              )}
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
