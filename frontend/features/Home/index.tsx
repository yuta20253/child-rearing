'use client'

import { FavoriteFacilities } from '@/components/FavoriteFacility/FavoriteFacilities';
import { TodayEvents } from '@/components/TodayEvent/TodayEvents';
import axios from 'axios';
import { useEffect, useState } from 'react';
import { RequireAuth } from '@/components/RequireAuth';

type WeekDay = {
  date: string;
  day: string;
};

type Event = {
  id: number;
  title: string;
  description: string;
  start_datetime: string;
  end_datetime: string;
  capacity: number;
  memo: string;
};

type FacilityFavorite = {
  id: number;
  name: string;
};

export const Home = (): React.JSX.Element => {
    const [week, setWeek] = useState<WeekDay[]>([]);
    const [events, setEvents] = useState<Event[]>([]);
    const [facilityFavorities, setFacilityFavorities] = useState<FacilityFavorite[]>([]);

    facilityFavorities.map((facilityFavorite) => console.log(facilityFavorite));
    useEffect(() => {
        const fetchWeek = async () => {
            const token = localStorage.getItem('token');
            try {
                const res = await axios.get(process.env.NEXT_PUBLIC_BACKEND_URL + '/api', {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        Accept: 'application/json',
                    },}

                );
                setWeek(res.data.data.week);
                setEvents(res.data.data.events);
                setFacilityFavorities(res.data.data.facilityFavorities)

            } catch (error) {
                console.error('曜日取得エラー:', error);
            }
        };
        fetchWeek();
    }, [])

    return (
        <RequireAuth>
            <div className="flex items-center justify-center  bg-gradient-to-tr">
                <div className="relative w-3/4 sm:max-w-md md:max-w-lg lg:max-w-xl p-4 sm:p-2 flex flex-col space-y-2">
                    <div className="p-2">
                        <div className="items-center justify-center rounded-lg">
                            <p className="p-2 text-2xl text-center text-white bg-pink-200 rounded-md">子育てサポート</p>
                        </div>
                    </div>
                    {/** カレンダー部分 */}
                    <div className="flex flex-col items-center justify-center rounded-lg mb-6">
                        <p className="text-center font-bold">{week.length > 0 ? new Date(week[0].date).getMonth() + 1 : '' }月 カレンダー/予定登録</p>
                        <div className="bg-yellow-50 m-4 p-4 rounded shadow w-full max-w-[700px] mx-auto overflow-x-auto">
                            <table className="table-fixed border-collapse text-center w-full">
                                <thead>
                                    <tr>
                                        {week.map((day, i) => (
                                        <th
                                            key={i}
                                            className="w-[14.2857%] min-w-[60px] px-3 py-2 whitespace-nowrap"
                                        >
                                            {day['day']}
                                        </th>
                                        ))}
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        {week.map((date, i) => (
                                        <td key={i} className="px-2 py-4 h-12">
                                            {
                                                date['date'].slice(-2).replace(/^0/, "")
                                            }
                                        </td>
                                        ))}
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {/** イベント部分 */}
                    <TodayEvents todayEvents={events} />
                    {/** お気に入り施設 */}
                    <FavoriteFacilities facilityFavorities={facilityFavorities} />
                    <div className="w-full bg-pink-300 text-white p-2 rounded mt-6">
                        <div className="flex justify-center">
                            <button className="font-semibold px-6 py-2 rounded">
                                施設を探す
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </RequireAuth>
    );
};
