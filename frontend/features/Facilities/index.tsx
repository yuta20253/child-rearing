'use client';

import { useState } from 'react';
import { useForm } from 'react-hook-form';
import { getFacilities } from '@/libs/services/facilities';
import { useEffect } from 'react';
import { Facility } from '@/types/generated/api';
import { RequireAuth } from '@/components/RequireAuth';
import { FacilityCard } from './FacilityCard';
import dynamic from 'next/dynamic';
import { useSubmit } from './hooks';
import { useSearchParams } from 'next/navigation';

type FacilityNameForm = {
  name: string;
};

const Map = dynamic(() => import('./Map').then(mod => mod.Map), { ssr: false });

export const Facilities = (): React.JSX.Element => {
  const [isLoading, setIsLoading] = useState<boolean>(true);
  const [facilities, setFacilities] = useState<Facility[]>([]);
  const searchParams = useSearchParams();
  const name = searchParams.get('name');
  const heading = name ? `「${name}」の検索結果（${facilities.length}件）` : '施設を検索';

  console.log('施設一覧:', facilities);
  useEffect(() => {
    const token = localStorage.getItem('token');
    if (!token) return;
    const fetchData = async () => {
      try {
        const data = await getFacilities(token, name ?? undefined);
        if (Array.isArray(data)) {
          setFacilities(data);
        }
      } catch (error) {
        console.error('施設情報の取得に失敗しました', error);
      } finally {
        setIsLoading(false);
      }
    };
    fetchData();
  }, [name]);

  const {
    register,
    handleSubmit,
    formState: { errors },
    reset,
  } = useForm<FacilityNameForm>({
    defaultValues: {
      name: name ?? '',
    },
  });
  const { onSubmit } = useSubmit(reset);

  return (
    <RequireAuth>
      <div className="">
        {!isLoading ? (
          <div>
            <h4 className="text-2xl font-bold my-6 text-center">施設一覧</h4>
            <div className="text-center">
              <div className="max-w-[400px] mx-auto mt-4 text-left">
                <h1 className="text-xl font-bold my-6 text-center">{heading}</h1>
                <form className="flex space-x-2" onSubmit={handleSubmit(onSubmit)}>
                  <input
                    type="text"
                    placeholder="施設名で検索"
                    defaultValue={name ?? ''}
                    {...register('name', { required: '検索キーワードを入力してください。' })}
                    className="flex-1 border rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                  />
                  <button type="submit" className="bg-pink-200 text-white px-4 py-2 rounded-md">
                    検索
                  </button>
                </form>
                {errors.name && <p className="text-red-500 text-sm">{errors.name.message}</p>}
              </div>
            </div>
            <div className="text-center">
              <div className="max-w-[400px] mx-auto mt-4 text-left">
                <p className="mb-1 font-bold">🗾 地図で見る</p>
                <div className="flex space-x-2 border">
                  <Map facilities={facilities} />
                </div>
              </div>
            </div>
            <div className="flex flex-col items-center mt-4">
              {facilities?.length === 0 ? (
                <p>施設が登録されていません。</p>
              ) : (
                <div className="w-full max-w-4xl">
                  {facilities?.map(facility => (
                    <FacilityCard facility={facility} key={facility.id} />
                  ))}
                </div>
              )}
            </div>
          </div>
        ) : (
          <div></div>
        )}
      </div>
    </RequireAuth>
  );
};
