// resources/js/app.js
import './bootstrap'

// Otros scripts
import './fontawesome-v7';
import './sweetalert2-v11';
import 'flowbite';

Alpine.data('otpInputs', ({ length = 6, onlyDigits = true } = {}) => ({
    length,
    onlyDigits,
    digits: Array.from({ length }, () => ''),
    init() {
        // Enfocar el primero al montar
        this.$nextTick(() => this.$refs['code-1']?.focus());
    },
    sanitize(value) {
        if (!value) return '';
        value = String(value);
        // Mantén un solo carácter; limita a dígitos si onlyDigits
        value = this.onlyDigits ? value.replace(/\D/g, '') : value;
        return value.slice(-1);
    },
    setFocus(index) {
        const id = `code-${index + 1}`;
        const el = this.$refs[id];
        if (el) el.focus();
    },
    onInput(index, e) {
        const clean = this.sanitize(e.target.value);
        this.digits[index] = clean;
        e.target.value = clean; // refleja limpieza en el DOM

        if (clean && index < this.length - 1) {
            this.setFocus(index + 1);
        }

        // Dispara evento cuando está completo
        if (this.digits.every(c => c !== '')) {
            this.$dispatch('otp-complete', this.digits.join(''));
        }

        // (Opcional) sincroniza con Livewire 3:
        // this.$wire?.set('otp', this.digits.join(''));
    },
    onKeydown(index, e) {
        const key = e.key;

        // Navegación con flechas
        if (key === 'ArrowLeft' && index > 0) {
            e.preventDefault(); this.setFocus(index - 1);
        }
        if (key === 'ArrowRight' && index < this.length - 1) {
            e.preventDefault(); this.setFocus(index + 1);
        }

        // Retroceso: si está vacío, ir atrás
        if (key === 'Backspace') {
            if (this.digits[index] === '' && index > 0) {
                e.preventDefault();
                this.setFocus(index - 1);
                // Limpia la anterior
                const prevId = `code-${index}`;
                const prev = this.$refs[prevId];
                if (prev) {
                    this.digits[index - 1] = '';
                    prev.value = '';
                }
            }
            return; // permite borrar si había contenido
        }

        // Limita la entrada
        if (this.onlyDigits) {
            const allowed = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            const control = ['Tab', 'ArrowLeft', 'ArrowRight', 'Home', 'End'];
            if (!allowed.includes(key) && !control.includes(key)) {
                // Permite pegar (Control/Meta+v)
                if (!((e.ctrlKey || e.metaKey) && (key.toLowerCase() === 'v'))) {
                    e.preventDefault();
                }
            }
        }
    },
    handlePaste(e) {
        const target = e.target;
        if (!(target instanceof HTMLInputElement)) return;
        const text = (e.clipboardData || window.clipboardData)?.getData('text') || '';
        const clean = this.onlyDigits ? text.replace(/\D/g, '') : text.replace(/\s/g, '');
        if (!clean) return;

        // Comienza desde el índice del input enfocado
        const currentId = target.id;
        const startIndex = Math.max(0, Number(currentId?.split('-')[1]) - 1 || 0);

        let j = 0;
        for (let i = startIndex; i < this.length && j < clean.length; i++, j++) {
            const ch = clean[j];
            this.digits[i] = ch;
            const ref = this.$refs[`code-${i + 1}`];
            if (ref) ref.value = ch;
        }

        // Enfoca el siguiente disponible o el último
        const nextIndex = Math.min(startIndex + clean.length, this.length - 1);
        this.setFocus(nextIndex);
        if (this.digits.every(c => c !== '')) {
            this.$dispatch('otp-complete', this.digits.join(''));
        }

        e.preventDefault();
    }
}));


