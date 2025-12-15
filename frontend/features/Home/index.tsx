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

type YearMonth = {
  year: number;
  month: number;
};

export const Home = (): React.JSX.Element => {
  const [events, setEvents] = useState<ApiEvent[]>([]);
  const [facilityFavorities, setFacilityFavorities] = useState<FacilityFavorite[]>([]);
  const [selectedDate, setSelectedDate] = useState<string>(new Date().toISOString().slice(0, 10));
  const [token, setToken] = useState<string | null>(null);
  const today = new Date();
  const [currentMonth, setCurrentMonth] = useState<YearMonth>({
    year: today.getFullYear(),
    month: today.getMonth() + 1,
  });

  useEffect(() => {
    setToken(localStorage.getItem('token'));
  }, []);

  useEffect(() => {
    if (!token) return;

    const fetchMonthDate = async () => {
      const headers = {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
      };

      try {
        const resData = await axios.get(
          `${process.env.NEXT_PUBLIC_BACKEND_URL}/api/calendar/events`,
          {
            params: currentMonth,
            headers,
          }
        );

        setEvents(resData.data.events);
      } catch (error) {
        console.error('トップページデータ取得エラー:', error);
      }
    };
    fetchMonthDate();
  }, [token, currentMonth.year, currentMonth.month, currentMonth]);

  useEffect(() => {
    if (!token) return;

    const fetchFavorites = async () => {
      const headers = {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
      };

      try {
        const resData = await axios.get(`${process.env.NEXT_PUBLIC_BACKEND_URL}/api/favorites`, {
          headers,
        });

        setFacilityFavorities(resData.data.facilityFavorities);
      } catch (error) {
        console.error('トップページデータ取得エラー:', error);
      }
    };
    fetchFavorites();
  }, [token]);

  const { handleDatesSet, handleChangeDate } = handleDateAction({
    setSelectedDate,
    setCurrentMonth,
  });

  return (
    <RequireAuth>
      <div className="flex items-center justify-center  bg-gradient-to-tr">
        <div className="relative w-full max-w-[1000px] p-5 flex flex-col space-y-4">
          <Calender
            events={events}
            selectedDate={selectedDate}
            handleDatesSet={handleDatesSet}
            handleChangeDate={handleChangeDate}
          />
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
