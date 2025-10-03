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
  loginUser: (data: { email: string; password: string }, params: RequestParams = {}) => api.login.loginUser(data, params),
};

export const logout = {
  logoutUser: (params: RequestParams = {}) => api.logout.logoutUser(params),
};

export const passwordResetRequest = {
  passwordResetRequest: (data: { email: string }, params: RequestParams = {}) => api.passwordResetRequest.passwordResetRequest(data, params),
};

export const passwordResetVerify = {
  passwordResetVerify: (data: { token: string; email: string }, params: RequestParams = {}) => api.passwordResetVerify.passwordResetVerify(data, params),
};

export const passwordReset = {
  passwordReset: (data: { token: string; email: string; password: string }, params: RequestParams = {}) => api.passwordReset.passwordReset(data, params),
};

export const signUp = {
  signUpUser: (data: { name: string; email: string; password: string; password_confirmation: string }, params: RequestParams = {}) => api.signUp.signUpUser(data, params),
};

export const deleteAccount = {
  deleteAccount: (params: RequestParams = {}) => api.deleteAccount.deleteAccount(params),
};

export const facilities = {
  facilitiesInfo: (params: RequestParams = {}) => api.facilities.facilitiesInfo(params),
};

export const facility = {
  facility: (id: number, params: RequestParams = {}) => api.facility.facilityInfo(id, params),
};

export const profile = {
  myProfile: (params: RequestParams = {}) => api.profile.myProfile(params),
};
