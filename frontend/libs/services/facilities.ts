import { Facility } from '@/types/generated/api';
import { facilities, facility } from './apiClient';

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

export const getFacility = async (token: string, id: number): Promise<Facility> => {
  try {
    const response = await facility.facilityInfo(id, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    const data = response.data.facility;

    if (!data) throw new Error('施設データが存在しません');

    return data;
  } catch (error) {
    console.log(error);
    const message =
      error instanceof Error
        ? error.message
        : typeof error === 'string'
          ? error
          : '不明なエラーが発生しました';
    throw new Error(message);
  }
};
