import { clientWithToken } from './apiClient';

export const postReview = async (
  token: string,
  facilityId: number,
  comment: string,
  rating: number
) => {
  try {
    const client = clientWithToken(token);
    const response = await client.api.postFacilityReview(facilityId, {
      comment,
      rating,
    });

    return response.data;
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
