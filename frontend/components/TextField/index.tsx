import { InputHTMLAttributes } from "react";
import { FieldError } from "react-hook-form";

type TextFieldProps = {
    id: string;
    lavel: string;
    error?: FieldError;
} & InputHTMLAttributes<HTMLInputElement>;

export const TextField = ({ id, lavel, error, ...inputProps }: TextFieldProps): React.JSX.Element => {
    return (
          <div className="flex flex-col w-full">
            <label htmlFor={id} className="text-sm font-medium text-gray-700 mb-1">
                {lavel}
            </label>
            <input
              id={id}
              className={`w-full p-3 rounded-xl border border-gray-300 placeholder-gray-400 shadow-inner
                focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-purple-500
                transition-all duration-300
                ${error ? 'border-red-500' : 'border-gray-300'}`}
                {...inputProps}
            />
            {error && <p className="mt-1 text-sm text-red-600">{error.message}</p>}
          </div>
    )
};
