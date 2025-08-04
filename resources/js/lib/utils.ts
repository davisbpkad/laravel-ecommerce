import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    // Simple implementation to avoid [object Object] issues
    const classes: string[] = [];
    
    for (const input of inputs) {
        if (typeof input === 'string' && input.trim()) {
            classes.push(input.trim());
        } else if (Array.isArray(input)) {
            const nested = cn(...input);
            if (nested) classes.push(nested);
        } else if (typeof input === 'object' && input !== null) {
            for (const [key, value] of Object.entries(input)) {
                if (value) classes.push(key);
            }
        }
    }
    
    return classes.join(' ');
}

// Keep the original for reference if needed
export function cnOriginal(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}
