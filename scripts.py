from PIL import Image
import os

# 🔧 Set your image directory here
folder_path = r"C:\Users\nfsgi\OneDrive\Desktop\images"

# Loop through all files in the directory
for filename in os.listdir(folder_path):
    if not filename.lower().endswith(('.png','.jpeg', '.webp', '.bmp', '.tiff')):
        continue  # Skip non-target formats

    img_path = os.path.join(folder_path, filename)
    name_without_ext = os.path.splitext(filename)[0]
    new_filename = name_without_ext + '.jpg'
    new_path = os.path.join(folder_path, new_filename)

    try:
        with Image.open(img_path) as img:
            # Convert to RGB (JPEG doesn't support alpha)
            rgb_img = img.convert('RGB')
            rgb_img.save(new_path, 'JPEG')
            print(f"✅ Converted: {filename} → {new_filename}")

        # Delete the original file
        os.remove(img_path)
        print(f"🗑️ Deleted original file: {filename}")

    except Exception as e:
        print(f"❌ Failed to convert {filename}: {e}")
