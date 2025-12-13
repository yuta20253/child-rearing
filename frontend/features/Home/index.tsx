'use client';

import { FavoriteFacilities } from '@/features/Home/FavoriteFacility';
import { Events } from '@/features/Home/Events';
import axios from 'axios';
import { useEffect, useState } from 'react';
import { RequireAuth } from '@/components/RequireAuth';
import { Event as ApiEvent } from '@/types/generated/api';
import { Calender } from './Calender';
import { handleDateAction } from './Calender/hook';

type FacilityFavorite = {
  id: number;
  name: string;
  address: string;
  rating: number;
};

export const Home = (): React.JSX.Element => {
  const [events, setEvents] = useState<ApiEvent[]>([]);
  const [facilityFavorities, setFacilityFavorities] = useState<FacilityFavorite[]>([]);
  const [selectedDate, setSelectedDate] = useState<string>(new Date().toISOString().slice(0, 10));
  const [token, setToken] = useState<string | null>(null);

  useEffect(() => {
    const storedToken = localStorage.getItem('token');
    setToken(storedToken);

    const fetchWeek = async () => {
      const headers = {
        Authorization: `Bearer ${storedToken}`,
        Accept: 'application/json',
      };

      try {
        const [eventsRes, facilityFavoritiesRes] = await Promise.all([
          axios.get(`${process.env.NEXT_PUBLIC_BACKEND_URL}/api/calendar/events`, {
            params: {
              year: Number(selectedDate.slice(0, 4)),
              month: Number(selectedDate.slice(5, 7)),
            },
            headers,
          }),
          axios.get(`${process.env.NEXT_PUBLIC_BACKEND_URL}/api/favorites`, { headers }),
        ]);

        setEvents(eventsRes.data.events);
        setFacilityFavorities(facilityFavoritiesRes.data.data.facilityFavorities);
      } catch (error) {
        console.error('トップページデータ取得エラー:', error);
      }
    };
    fetchWeek();
  }, [selectedDate]);

  const { handleDatesSet, handleChangeDate } = handleDateAction({ token, setEvents, setSelectedDate });

  const eventsDate = new Set(
    events.filter(ev => ev.start_datetime)
    .map(ev => ev.start_datetime.slice(0, 10))
  );

  return (
    <RequireAuth>
      <div className="flex items-center justify-center  bg-gradient-to-tr">
        <div className="relative w-full max-w-[1000px] p-5 flex flex-col space-y-4">
          <Calender events={events} selectedDate={selectedDate} eventsDate={eventsDate} handleDatesSet={handleDatesSet} handleChangeDate={handleChangeDate} />
          <Events
            events={events.filter(ev => ev.start_datetime.slice(0, 10) === selectedDate)}
            selectedDate={selectedDate}
          />
          <FavoriteFacilities facilityFavorities={facilityFavorities} />
          <div className="w-full bg-pink-300 text-white p-2 rounded mt-6">
            <div className="flex justify-center">
              <button className="font-semibold px-6 py-2 rounded">施設を探す</button>
            </div>
          </div>
        </div>
      </div>
    </RequireAuth>
  );
};
