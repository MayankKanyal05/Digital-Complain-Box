import cv2
import os
def extract_frames(video_folder, output_folder):

    os.makedirs(output_folder, exist_ok=True)
    for video_name in os.listdir(video_folder):
        video_path = os.path.join(video_folder, video_name)
        cap = cv2.VideoCapture(video_path)
        count = 0
        while True:
            success, frame = cap.read()
            if not success:
                break
            if count % 30 == 0:
                frame_name = f"{video_name}_{count}.jpg"
                frame_path = os.path.join(output_folder, frame_name)
                cv2.imwrite(frame_path, frame)
            count += 1
        cap.release()
# Extract frames from REAL videos
extract_frames(
    "videos/real",
    "dataset/train/real"
)

# Extract frames from FAKE videos
extract_frames(
    "videos/fake",
    "dataset/train/fake"
)
print("Frame Extraction Complete")