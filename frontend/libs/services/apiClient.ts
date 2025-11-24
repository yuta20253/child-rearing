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

const api = apiClient;

export const login = {
  loginUser: (data: { email: string; password: string }, params: RequestParams = {}) =>
    api.api.loginUser(data, params),
};

export const logout = {
  logoutUser: (params: RequestParams = {}) => api.api.logoutUser(params),
};

export const passwordResetRequest = {
  passwordResetRequest: (data: { email: string }, params: RequestParams = {}) =>
    api.api.passwordResetRequest(data, params),
};

export const passwordResetVerify = {
  passwordResetVerify: (data: { token: string; email: string }, params: RequestParams = {}) =>
    api.api.passwordResetVerify(data, params),
};

export const passwordReset = {
  passwordReset: (
    data: { token: string; email: string; password: string },
    params: RequestParams = {}
  ) => api.api.passwordReset(data, params),
};

export const signUp = {
  signUpUser: (
    data: { name: string; email: string; password: string; password_confirmation: string },
    params: RequestParams = {}
  ) => api.api.signUpUser(data, params),
};

export const deleteAccount = {
  deleteAccount: (params: RequestParams = {}) => api.api.deleteAccount(params),
};

export const facilities = {
  facilitiesInfo: (query?: { name?: string }, params: RequestParams = {}) =>
    api.api.facilitiesInfo(query, params),
};

export const facility = {
  facilityInfo: (id: number, params: RequestParams = {}) => api.api.facilityInfo(id, params),
};

export const profile = {
  myProfile: (params: RequestParams = {}) => api.api.myProfile(params),
};
