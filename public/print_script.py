import subprocess
import sys
import platform

def set_default_printer(printer_name, grayscale):
    os_type = platform.system()

    try:
        if os_type in ['Linux', 'Darwin']:  # Unix-based systems (Linux, macOS)
            # Set the default printer
            subprocess.run(['lpoptions', '-d', printer_name], check=True)
            
            # Set default options for the printer
            grayscale_option = 'CNIJGrayScale=1' if grayscale else 'CNIJGrayScale=0'
            subprocess.run(['lpoptions', '-p', printer_name, '-o', grayscale_option], check=True)
            
            # Set print quality to 5
            subprocess.run(['lpoptions', '-p', printer_name, '-o', 'CNIJPrintQuality=5'], check=True)
            subprocess.run(['lpoptions', '-p', printer_name, '-o', 'landscape'], check=True)

        elif os_type == 'Windows':
            # Set default printer
            subprocess.run(['powershell', '-Command', f'Set-Printer -Name "{printer_name}" -IsDefault $true'], check=True)
            
            # PowerShell does not provide straightforward commands to set print options like grayscale or quality.
            # For advanced configurations, you may need to use the printer's driver software or a custom script.
            
            # Placeholder for setting options like grayscale (advanced configurations might be required)
            grayscale_option = 'Grayscale=True' if grayscale else 'Grayscale=False'
            # Example of how to set advanced options could involve using the printer's management interface or additional scripts.
            print(f"Advanced print options such as grayscale setting require manual configuration or custom scripts.")

        else:
            print(f"Sistem operasi {os_type} tidak didukung.")

        print(f"Printer default diatur ke {printer_name} dengan opsi {'hitam putih' if grayscale else 'warna'} dan kualitas 5.")
    except subprocess.CalledProcessError as e:
        print(f"Gagal mengatur printer default: {e}")

def print_file(file_path, copies):
    os_type = platform.system()

    try:
        if os_type in ['Linux', 'Darwin']:  # Unix-based systems (Linux, macOS)
            subprocess.run(['lp', '-n', str(copies), file_path], check=True)
        
        elif os_type == 'Windows':
            # Print file using PowerShell
            subprocess.run(['powershell', '-Command', f'Start-Process -FilePath "{file_path}" -ArgumentList "/p /h /t:{copies}" -NoNewWindow'], check=True)

        else:
            print(f"Sistem operasi {os_type} tidak didukung.")

        print(f"File {file_path} dicetak {copies} salinan.")
    except subprocess.CalledProcessError as e:
        print(f"Gagal mencetak file: {e}")

if __name__ == "__main__":
    if len(sys.argv) != 4:
        print("Penggunaan: python print_script.py <serial_number> <grayscale> <copies>")
        sys.exit(1)

    serial_number = sys.argv[1]
    grayscale = sys.argv[2].lower() == 'true'  # Convert string to boolean
    copies = int(sys.argv[3])  # Convert string to integer

    # Construct the file path
    file_path = f'storage/sertifikat/file/{serial_number}.pdf'

    # Printer name
    printer_name = 'Canon_iP2700_series'
    
    # Set default printer settings
    set_default_printer(printer_name, grayscale)
    print_file(file_path, copies)
