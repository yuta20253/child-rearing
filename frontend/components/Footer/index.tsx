'use client'

export const Footer = (): React.JSX.Element => {
    return (
        <div className="fixed bottom-0 left-0 w-full bg-pink-200 z-20">
            <div className="flex items-center justify-center min-h-[64px] px-4 max-w-6xl mx-auto">
                <span className="text-white text-sm">
                    &copy; {new Date().getFullYear()} Your Company. All rights reserved.
                </span>
            </div>
        </div>
    );
};
