import { apiClient } from './apiClient';

type ErrorWithMessage = {
  message: string;
};

type NestedErrorWithMessage = {
  error: ErrorWithMessage;
};

type LoginResponse = {
  token: string;
  user: {
    id: number;
    name: string;
    email: string;
  };
};

type SignUpResponse = {
  token: string;
  user: {
    id: number;
    name: string;
    email: string;
  };
};

function isErrorWithMessage(error: unknown): error is ErrorWithMessage {
  return (
    typeof error === 'object' &&
    error !== null &&
    'message' in error &&
    typeof (error as Record<string, unknown>).message === 'string'
  );
}

function isNestedErrorWithMessage(error: unknown): error is NestedErrorWithMessage {
  return (
    typeof error === 'object' &&
    error !== null &&
    'error' in error &&
    isErrorWithMessage((error as Record<string, unknown>).error)
  );
}

export const extractApiErrorMessage = (error: unknown, fallback: string): string => {
  if (isNestedErrorWithMessage(error)) {
    return (error as NestedErrorWithMessage).error.message;
  }

  if (isErrorWithMessage(error)) {
    return error.message;
  }

  return fallback;
};

export const loginAuth = async ({
  email,
  password,
}: {
  email: string;
  password: string;
}): Promise<LoginResponse> => {
  try {
    const response = await apiClient.login.loginUser({ email, password });

    // response.data に型を付ける
    const data = response.data as LoginResponse;

    if (!data.token) throw new Error('トークンがありません');

    return data;
  } catch (error) {
    console.error(error);
    throw new Error(extractApiErrorMessage(error, 'ログインに失敗しました'));
  }
};

export const signUpAuth = async ({
  email,
  password,
  password_confirmation,
  name,
}: {
  email: string;
  password: string;
  password_confirmation: string;
  name: string;
}): Promise<SignUpResponse> => {
  try {
    const response = await apiClient.signUp.signUpUser(
      { email, password, password_confirmation, name },
      { secure: false }
    );

    const data = response.data as SignUpResponse;

    if (!data.token) throw new Error('トークンがありません');

    return data;
  } catch (error) {
    console.error(error);
    throw new Error(extractApiErrorMessage(error, '新規登録に失敗しました'));
  }
};
