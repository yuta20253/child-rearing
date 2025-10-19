import { SubmitHandler } from 'react-hook-form';
import axios from 'axios';
import { SetStateAction } from 'react';
import { Facility } from '@/types/generated/api';

type Props = {
  setFacilities: (value: SetStateAction<Facility[]>) => void;
};

type FacilityNameForm = {
  name: string;
};

export const useSubmit = ({ setFacilities }: Props) => {
  const onSubmit: SubmitHandler<FacilityNameForm> = async (data: FacilityNameForm) => {
    console.log('data:', data);
    const token = localStorage.getItem('token');
    const url = process.env.NEXT_PUBLIC_BACKEND_URL + `/api/facilities?name=${data.name}`;
    const headers = {
      Authorization: `Bearer ${token}`,
    };

    try {
      const response = await axios.get(url, { headers });
      const fetchData = response.data?.facilities;

      if (Array.isArray(fetchData)) {
        setFacilities(fetchData);
        console.log('検索が使用されました。', fetchData);
      } else {
        console.warn('APIレスポンスに施設配列が含まれていません');
        setFacilities([]);
      }
    } catch (error) {
      console.error('施設検索エラー:', error);
      setFacilities([]);
    }
  };
  return {
    onSubmit,
  };
};
