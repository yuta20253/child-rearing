'use client';

import React, { createContext, useCallback, useContext, useRef, useState } from 'react';

type Toast = { id: number; message: string };

type ToastContextValue = {
  showToast: (message: string) => void;
};

const ToastContext = createContext<ToastContextValue | undefined>(undefined);

export const ToastProvider = ({ children }: { children: React.ReactNode }) => {
  const [toasts, setToasts] = useState<Toast[]>([]);
  const counter = useRef(0);

  const showToast = useCallback((message: string) => {
    const id = ++counter.current;
    setToasts(prev => [...prev, { id, message }]);

    window.setTimeout(() => {
      setToasts(prev => prev.filter(x => x.id !== id));
    }, 3000)
  }, []);

  return (
    <ToastContext.Provider value={{ showToast }}>
      {children}

      <div className="fixed bottom-6 right-6 z-50 flex flex-col gap-3">
        {toasts.map(t => (
          <div
            key={t.id}
            className="rounded-md bg-black/90 text-white px-4 py-2 shadow-lg max-w-xs"
            role="status"
          >
            {t.message}
          </div>
        ))}
      </div>
    </ToastContext.Provider>
  );
};

export const useToast = (): ToastContextValue => {
  const ctx = useContext(ToastContext);
  if (!ctx) throw new Error('useToast must be used within ToastProvider');
  return ctx;
};
