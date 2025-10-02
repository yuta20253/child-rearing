import { Api, RequestParams } from '@/types/generated/api';

export const apiClient = new Api({
  baseUrl: process.env.NEXT_PUBLIC_BACKEND_URL,
  securityWorker: (token: string | null | undefined): RequestParams | void => {
    if (!token) return;
    return {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    };
  },
});

export const clientWithToken = (token: string) =>
  new Api({
    baseUrl: process.env.NEXT_PUBLIC_BACKEND_URL,
    securityWorker: (): RequestParams => ({
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }),
  });
