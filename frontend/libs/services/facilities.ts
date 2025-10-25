import { Facility } from '@/types/generated/api';
import { facilities } from './apiClient';

export const getFacilities = async (token: string, name?: string): Promise<Facility[] | null> => {
  try {
    const response = await facilities.facilitiesInfo(
      { name },
      {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      }
    );

    const data = response.data.facilities;

    if (!data) return null;

    return data;
  } catch (error) {
    console.error(error);
    throw new Error('施設一覧の取得に失敗しました');
  }
};
