'use client'

import { loginAuth, signUpAuth } from '@/libs/services/auth';
import {
  getCurrentUser,
} from '@/libs/services/user';
import { createContext, useContext, useState, ReactNode, useEffect, useMemo } from 'react';

type User = {
  id: number;
  name: string;
  email: string;
};

type AuthState = {
  user: User | null;
  loading: boolean;
  hydrated: boolean;
};

type AuthActions = {
  login: (p: { email: string; password: string }) => Promise<void>;
  signUp: (p: {
    email: string;
    password: string;
    password_confirmation: string;
    name: string;
  }) => Promise<void>;
};

const AuthStateContext = createContext<AuthState | undefined>(undefined);
const AuthActionsContext = createContext<AuthActions | undefined>(undefined);

const TOKEN_KEY = 'token';
const USER_KEY = 'user';

export const AuthProvider = ({ children }: { children: ReactNode }) => {
    const [user, setUser] = useState<User | null>(null);
    const [loading, setLoading] = useState<boolean>(true);
    const [hydrated, setHydrated] = useState<boolean>(false);

    useEffect(() => {
        const boot = async () => {
        try {
            const token = localStorage.getItem(TOKEN_KEY);
            const cashed = localStorage.getItem(USER_KEY);
            if (cashed) {
            try {
                setUser(JSON.parse(cashed));
            } catch (error) {
                console.error('ユーザー情報の復元に失敗:', error);
            }
            }
            if (token) {
            const fresh = await getCurrentUser(token);
            if (fresh) {
                setUser(fresh);
                localStorage.setItem(USER_KEY, JSON.stringify(fresh));
            }
            }
        } catch (error) {
            console.error('auth boot failed', error);
            setUser(null);
            localStorage.removeItem(USER_KEY);
            localStorage.removeItem(TOKEN_KEY);
        } finally {
            setLoading(false);
            setHydrated(true);
        }
        };
        boot();
    }, []);

    const login: AuthActions['login'] = async ({ email, password }) => {
        setLoading(true);
        try {
            const { token, user } = await loginAuth({ email, password });
            localStorage.setItem(TOKEN_KEY, token);
            localStorage.setItem(USER_KEY, JSON.stringify(user));
            setUser(user);
        } finally {
            setLoading(false);
        }
    };

    const signUp: AuthActions['signUp'] = async p => {
        setLoading(true);
        try {
            const { user, token } = await signUpAuth(p);
            localStorage.setItem(TOKEN_KEY, token);
            localStorage.setItem(USER_KEY, JSON.stringify(user));
            setUser(user);
        } finally {
            setLoading(false);
        }
    };

    const stateValue = useMemo<AuthState>(
        () => ({ user, loading, hydrated }),
        [user, loading, hydrated]
    );

    const actionsValue: AuthActions = {
        login,
        signUp
    };

    return (
        <AuthActionsContext value={actionsValue}>
            <AuthStateContext value={stateValue}>{children}</AuthStateContext>
        </AuthActionsContext>
    );
};

export const useAuthState = (): AuthState => {
  const context = useContext(AuthStateContext);
  if (!context) throw new Error('useAuthState must be used within an AuthProvider');
  return context;
};

export const useAuthActions = (): AuthActions => {
  const context = useContext(AuthActionsContext);
  if (!context) throw new Error('useAuthActions must be used within an AuthProvider');
  return context;
};
